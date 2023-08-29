<?php

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

use GuzzleHttp\Client;

echo [];
die;

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");

$query = 'query get_supporting_campaigns_by_team_event_asc($vanity: String!, $slug: String!, $limit: Int!, $cursor: String) {
  teamEvent(vanity: $vanity, slug: $slug) {
    publicId
    supportingCampaigns(first: $limit, after: $cursor) {
      edges {
        cursor
        node {
          publicId
          name
          description
          user {
            id
            username
            slug
          }
          slug
          avatar {
            alt
            src
          }
          goal {
            value
            currency
          }
          amountRaised {
            value
            currency
          }
          totalAmountRaised {
            value
            currency
          }
        }
      }
      pageInfo {
        startCursor
        endCursor
        hasNextPage
        hasPreviousPage
      }
    }
  }
}';

$operationName = 'get_supporting_campaigns_by_team_event_asc';
$variables = [
    'vanity' => '+relay-fm',
    'slug' => 'relay-fm-for-st-jude-2023',
    'limit' => 100,
];

$response = (new Client)->request('post', 'https://api.tiltify.com/', [
    'headers' => [
        'Content-Type' => 'application/json'
    ],
    'body' => json_encode([
        'query' => $query,
        'operationName' => $operationName,
        'variables' => $variables,
    ])
]);

$data = json_decode($response->getBody()->getContents(), true);
$campaigns = $data['data']['teamEvent']['supportingCampaigns']['edges'];

echo json_encode(array_map(function($c) {
    $raised = $c['node']['totalAmountRaised']['value'];
    $goal = $c['node']['goal']['value'];
    return [
        'title' => $c['node']['name'],
        'user' => $c['node']['user']['slug'],
        'slug' => $c['node']['slug'],
        'url' => sprintf('https://tiltify.com/@%s/%s', $c['node']['user']['slug'], $c['node']['slug']),
        'raised' => $raised,
        'goal' => $goal,
        'percentage' => ($goal > 0 && $raised > 0) ? number_format((($raised / $goal) * 100), 2) : null
    ];
}, $campaigns));