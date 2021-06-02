<?php
/**
 * @file
 * Contains \Drupal\custom_site_api\Controller\CustomSiteApiController.
 */
namespace Drupal\custom_site_api\Controller;

use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @category CustomSiteApiController
 */
class CustomSiteApiController {
  /**
   * @param  $site_api_key - the API key parameter
   * @param  NodeInterface $node - node from node id
   * @return JsonResponse
   */
  public function content($site_api_key, NodeInterface $node) {

    // fetch site api key from configuration
    $config = \Drupal::configFactory()->getEditable('system.site');
    $site_api_key_value = $config->get('siteapikey');

    // redirect correctly only when node type is page and site api key matches with url key
    if($node->getType() == 'page' && $site_api_key_value != 'No API Key yet' && $site_api_key_value == $site_api_key) {
        // Respond with the json representation of the node
        return new JsonResponse($node->toArray(), 200, ['Content-Type'=> 'application/json']);
    }

    // Respond with access denied
    return new JsonResponse(array("error" => "access denied"), 401, ['Content-Type'=> 'application/json']);
  }
}
