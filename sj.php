<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Phpfastcache\Helper\Psr16Adapter;

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");

function getRelay()
{
  $operationName = 'get_team_event_by_vanity_and_slug';
  $query = 'query get_team_event_by_vanity_and_slug($vanity: String!, $slug: String!) {
  teamEvent(vanity: $vanity, slug: $slug) {
    publicId
    legacyCampaignId
    name
    slug
    currentSlug
    status
    templateId
    publishedAt
    supportingCampaignCount
    colors {
      background
    }
    visibility {
      donate
      fePageCampaigns
      goal
      raised
      teamEventStats
      toolkit {
        url
        visible
      }
    }
    parentTeamEvent {
      slug
    }
    originalGoal {
      value
      currency
    }
    supportingType
    team {
      id
      publicId
      avatar {
        src
        alt
      }
      name
      slug
      memberCount
    }
    cause {
      id
      publicId
      name
      slug
      description
      avatar {
        alt
        height
        width
        src
      }
      paymentMethods {
        type
        currency
        sellerId
        minimumAmount {
          currency
          value
        }
      }
      paymentOptions {
        currency
        additionalDonorDetails
        additionalDonorDetailsType
        monthlyGiving
        monthlyGivingMinimumAmount
        minimumAmount
      }
    }
    fundraisingEvent {
      publicId
      legacyFundraisingEventId
      name
      slug
      avatar {
        alt
        height
        width
        src
      }
      paymentMethods {
        type
        currency
        sellerId
        minimumAmount {
          currency
          value
        }
      }
      paymentOptions {
        currency
        additionalDonorDetails
        additionalDonorDetailsType
        monthlyGiving
        minimumAmount
      }
    }
    supporting {
      cause {
        id
        publicId
        name
        slug
        description
        avatar {
          alt
          height
          width
          src
        }
        paymentMethods {
          type
          currency
          sellerId
          minimumAmount {
            currency
            value
          }
        }
        paymentOptions {
          currency
          additionalDonorDetails
          additionalDonorDetailsType
          monthlyGiving
          monthlyGivingMinimumAmount
          minimumAmount
        }
      }
      fundraisingEvent {
        publicId
        legacyFundraisingEventId
        name
        slug
        avatar {
          alt
          height
          width
          src
        }
        paymentMethods {
          type
          currency
          sellerId
          minimumAmount {
            currency
            value
          }
        }
        paymentOptions {
          currency
          additionalDonorDetails
          additionalDonorDetailsType
          monthlyGiving
          minimumAmount
        }
      }
    }
    description
    totalAmountRaised {
      currency
      value
    }
    goal {
      currency
      value
    }
    avatar {
      alt
      height
      width
      src
    }
    banner {
      alt
      height
      width
      src
    }
    livestream {
      type
      channel
    }
    milestones {
      publicId
      name
      amount {
        value
        currency
      }
      updatedAt
    }
    schedules {
      publicId
      name
      description
      startsAt
      endsAt
      updatedAt
    }
    rewards {
      active
      promoted
      fulfillment
      amount {
        currency
        value
      }
      name
      image {
        src
      }
      fairMarketValue {
        currency
        value
      }
      legal
      description
      publicId
      startsAt
      endsAt
      quantity
      remaining
      updatedAt
    }
    challenges {
      publicId
      amount {
        currency
        value
      }
      name
      active
      endsAt
      amountRaised {
        currency
        value
      }
      updatedAt
    }
    updatedAt
  }
}';

  $variables = [
    'vanity' => '+relay-fm',
    'slug' => 'relay-fm-for-st-jude-2023',
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

  $goal = $data['data']['teamEvent']['goal']['value'];
  $raised = $data['data']['teamEvent']['totalAmountRaised']['value'];
  $currency = '$';

  return [
    'title' => 'Relay FM for St. Jude 2023',
    'url' => 'https://relay.experience.stjude.org/',
    'goal' => $currency . $goal,
    'raised' => $currency . $raised,
    'percentage' => ($goal > 0 && $raised > 0) ? number_format((($raised / $goal) * 100), 2) : null,
    'mode' => 'light',
  ];
}

function getData($variables)
{
    $operationName = 'get_campaign_by_vanity_and_slug';
    $query = 'query get_campaign_by_vanity_and_slug($vanity: String!, $slug: String!) {
  campaign(vanity: $vanity, slug: $slug) {
    publicId
    legacyCampaignId
    name
    slug
    status
    showPolyline
    fitnessTotals {
      averagePaceMinutesMile
      averagePaceMinutesKilometer
      totalDistanceMiles
      totalDurationSeconds
      totalDistanceKilometers
      __typename
    }
    fitnessDailyActivity {
      date
      totalDistanceMiles
      totalDistanceKilometers
      __typename
    }
    fitnessActivities(first: 10) {
      edges {
        node {
          distanceMiles
          distanceKilometers
          durationSeconds
          elevationGainFeet
          elevationGainMeters
          id
          paceMinutesMile
          paceMinutesKilometer
          startDate
          obfuscatedPolyline
          fitnessActivityType {
            type
            __typename
          }
          __typename
        }
        __typename
      }
      __typename
    }
    fitnessGoals {
      currentValue
      goal
      type
      __typename
    }
    fitnessSettings {
      measurementUnit
      __typename
    }
    membership {
      id
      status
      __typename
    }
    originalGoal {
      value
      currency
      __typename
    }
    region {
      name
      __typename
    }
    team {
      id
      avatar {
        src
        alt
        __typename
      }
      name
      slug
      __typename
    }
    supportingAuctionHouses(first: 5) {
      edges {
        node {
          publicId
          name
          avatar {
            src
            __typename
          }
          link
          description
          user {
            id
            username
            __typename
          }
          __typename
        }
        __typename
      }
      __typename
    }
    bonfireCampaign {
      id
      description
      featuredItemImage {
        src
        __typename
      }
      featuredItemName
      featuredItemPrice {
        currency
        value
        __typename
      }
      url
      products {
        id
        productType
        sellingPrice {
          value
          currency
          __typename
        }
        __typename
      }
      __typename
    }
    supportedTeamEvent {
      publicId
      team {
        id
        avatar {
          src
          alt
          __typename
        }
        name
        slug
        __typename
      }
      avatar {
        alt
        height
        width
        src
        __typename
      }
      name
      slug
      currentSlug
      __typename
    }
    description
    totalAmountRaised {
      currency
      value
      __typename
    }
    goal {
      currency
      value
      __typename
    }
    avatar {
      alt
      height
      width
      src
      __typename
    }
    user {
      id
      username
      slug
      avatar {
        src
        alt
        __typename
      }
      __typename
    }
    livestream {
      type
      channel
      __typename
    }
    milestones {
      publicId
      name
      amount {
        value
        currency
        __typename
      }
      __typename
    }
    schedules {
      publicId
      name
      description
      startsAt
      endsAt
      __typename
    }
    rewards {
      active
      promoted
      fulfillment
      amount {
        currency
        value
        __typename
      }
      name
      image {
        src
        __typename
      }
      fairMarketValue {
        currency
        value
        __typename
      }
      legal
      description
      publicId
      startsAt
      endsAt
      quantity
      remaining
      __typename
    }
    challenges {
      publicId
      amount {
        currency
        value
        __typename
      }
      name
      active
      endsAt
      amountRaised {
        currency
        value
        __typename
      }
      __typename
    }
    polls {
      active
      amountRaised(vanity: $vanity, slug: $slug) {
        currency
        value
        __typename
      }
      totalAmountRaised {
        currency
        value
        __typename
      }
      name
      publicId
      pollOptions {
        name
        publicId
        amountRaised(vanity: $vanity, slug: $slug) {
          currency
          value
          __typename
        }
        totalAmountRaised {
          currency
          value
          __typename
        }
        __typename
      }
      __typename
    }
    cause {
      id
      publicId
      name
      slug
      description
      avatar {
        alt
        height
        width
        src
        __typename
      }
      paymentMethods {
        type
        currency
        sellerId
        minimumAmount {
          currency
          value
          __typename
        }
        __typename
      }
      paymentOptions {
        currency
        additionalDonorDetails
        additionalDonorDetailsType
        monthlyGiving
        monthlyGivingMinimumAmount
        minimumAmount
        __typename
      }
      __typename
    }
    fundraisingEvent {
      publicId
      legacyFundraisingEventId
      name
      slug
      avatar {
        alt
        height
        width
        src
        __typename
      }
      paymentMethods {
        type
        currency
        sellerId
        minimumAmount {
          currency
          value
          __typename
        }
        __typename
      }
      paymentOptions {
        currency
        additionalDonorDetails
        additionalDonorDetailsType
        monthlyGiving
        minimumAmount
        __typename
      }
      __typename
    }
    donationMatches {
      publicId
      startsAt
      endsAt
      startedAtAmount {
        value
        currency
        __typename
      }
      totalAmountRaised {
        value
        currency
        __typename
      }
      matchedAmountTotalAmountRaised {
        value
        currency
        __typename
      }
      pledgedAmount {
        value
        currency
        __typename
      }
      amount {
        value
        currency
        __typename
      }
      active
      matchedBy
      __typename
    }
    __typename
  }
}
';

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

    return $data;
}

$slug = $_GET['slug'] ?? null;
$vanity = $_GET['vanity'] ?? null;
$theme = $_GET['mode'] ?? 'light';

$key = str_replace('@', '', $vanity . $slug) ?: 'relayfmmaincampaign';
$Psr16Adapter = new Psr16Adapter('Files');

if (!$Psr16Adapter->has($key)) {
    if (is_null($vanity) || is_null($slug))
    {
      echo json_encode(getRelay());
      die;
    }
    $variables = [
        'vanity' => $vanity,
        'slug' => $slug,
    ];

    $data = getData($variables);

    if (isset($data['errors'])) {
        echo json_encode(getRelay());
        die;
    }

    $goal = $data['data']['campaign']['goal']['value'];
    $raised = $data['data']['campaign']['totalAmountRaised']['value'];
    $currency = '$';

    $data = [
        'title' => $data['data']['campaign']['name'],
        'url' => sprintf('https://tiltify.com/@%s/%s', $data['data']['campaign']['user']['username'], $data['data']['campaign']['slug']),
        'goal' => $currency . $goal,
        'raised' => $currency . $raised,
        'percentage' => ($goal > 0 && $raised > 0) ? number_format((($raised / $goal) * 100), 2) : null,
        'mode' => $theme,
    ];

    $Psr16Adapter->set($key, $data, 600);
} else {
    $data = $Psr16Adapter->get($key);
}

echo json_encode($data);
