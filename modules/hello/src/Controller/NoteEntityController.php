<?php

namespace Drupal\hello\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\hello\Entity\NoteEntityInterface;

/**
 * Class NoteEntityController.
 *
 *  Returns responses for Note entity routes.
 */
class NoteEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Note entity  revision.
   *
   * @param int $note_entity_revision
   *   The Note entity  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($note_entity_revision) {
    $note_entity = $this->entityManager()->getStorage('note_entity')->loadRevision($note_entity_revision);
    $view_builder = $this->entityManager()->getViewBuilder('note_entity');

    return $view_builder->view($note_entity);
  }

  /**
   * Page title callback for a Note entity  revision.
   *
   * @param int $note_entity_revision
   *   The Note entity  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($note_entity_revision) {
    $note_entity = $this->entityManager()->getStorage('note_entity')->loadRevision($note_entity_revision);
    return $this->t('Revision of %title from %date', ['%title' => $note_entity->label(), '%date' => format_date($note_entity->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Note entity .
   *
   * @param \Drupal\hello\Entity\NoteEntityInterface $note_entity
   *   A Note entity  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(NoteEntityInterface $note_entity) {
    $account = $this->currentUser();
    $langcode = $note_entity->language()->getId();
    $langname = $note_entity->language()->getName();
    $languages = $note_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $note_entity_storage = $this->entityManager()->getStorage('note_entity');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $note_entity->label()]) : $this->t('Revisions for %title', ['%title' => $note_entity->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all note entity revisions") || $account->hasPermission('administer note entity entities')));
    $delete_permission = (($account->hasPermission("delete all note entity revisions") || $account->hasPermission('administer note entity entities')));

    $rows = [];

    $vids = $note_entity_storage->revisionIds($note_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\hello\NoteEntityInterface $revision */
      $revision = $note_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $note_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.note_entity.revision', ['note_entity' => $note_entity->id(), 'note_entity_revision' => $vid]));
        }
        else {
          $link = $note_entity->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.note_entity.translation_revert', ['note_entity' => $note_entity->id(), 'note_entity_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.note_entity.revision_revert', ['note_entity' => $note_entity->id(), 'note_entity_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.note_entity.revision_delete', ['note_entity' => $note_entity->id(), 'note_entity_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['note_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
