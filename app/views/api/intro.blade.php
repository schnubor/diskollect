@extends('layout.main')

@section('title')
  API Introduction
@stop

@section('body')
  <div class="jumbotron" style="margin-top: -20px;">
    <div class="container">
      <h1>API Introduction</h1>
      <p>This is a quick introduction to the RESTful Diskollect API. The basic response format is JSON.<br>
      Check the examples below for more insights.</p>
    </div>
  </div>
  <div class="container">
    <!-- User -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><strong>Users</strong></h3>
      </div>
      <div class="panel-body">
        Retreive information about a user.
      </div>
      <!-- List group -->
      <ul class="list-group">
        <li class="list-group-item"><strong>Endpoints</strong> <br> <code>GET api/user/&lt;username&gt;</code> <br> or <br> <code>GET api/user_id/&lt;id&gt;</code></li>
        <li class="list-group-item"><strong>Example</strong> <br> <kbd>curl -i http://beta.diskollect.com/api/user/schnubor</kbd></li>
        <li class="list-group-item"><strong>Response</strong> <br> <pre><code class="json">HTTP/1.1 200 OK
Content-Type: application/json
Cache-Control: no-cache

{
  "error":false,
  "message":200,
  "user":{
    "id":"2",
    "email":"schnuppser@gmail.com",
    "username":"schnubor",
    "name":"Christian Kornd\u00f6rfer",
    "website":"http:\/\/www.chko.org",
    "location":"Berlin, Germany",
    "image":"\/images\/users\/user_2_leme_crop.jpg",
    "description":"have fun :)",
    "active":"1",
    "discogs_uri":"http:\/\/api.discogs.com\/users\/schnubor",
    "created_at":"2014-07-05 11:00:22",
    updated_at":"2014-08-24 22:31:34",
    "currency":"EUR"
  }
}
        </code></pre></li>
      </ul>
    </div>

    <!-- Collection -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><strong>Collection</strong></h3>
      </div>
      <div class="panel-body">
        Retreive information about a users vinyl collection.
      </div>
      <!-- List group -->
      <ul class="list-group">
        <li class="list-group-item"><strong>Endpoint</strong> <br> <code>GET api/collection/&lt;user_id&gt;</code></li>
        <li class="list-group-item"><strong>Example</strong> <br> <kbd>curl -i http://beta.diskollect.com/api/collection/2</kbd></li>
        <li class="list-group-item"><strong>Response</strong> <br> <pre><code class="json">HTTP/1.1 200 OK
Content-Type: application/json
Cache-Control: no-cache

{
  "error":false,
  "message":200,
  "collection":[
    {
      "id":"70",
      "user_id":"2",
      "artwork":"http:\/\/s.pixogs.com\/image\/R-4570366-1368696285-3832.jpeg",
      "artist":"Daft Punk",
      "title":"Random Access Memories",
      "label":"Columbia",
      "genre":"Electronic;Funk \/ Soul;Pop",
      "price":"19.95",
      "country":"UK, Europe & US",
      "size":"12",
      "count":"2",
      "color":"#000000",
      "type":"release",
      "notes":"Best record ever",
      "created_at":"2014-08-24 21:53:02",
      "updated_at":"2014-09-11 13:41:37",
      "releasedate":"17 May 2013",
      "releasetype":"EP",
      "catno":"88883716861",
      "weight":"460"
    },
    {
      "id":"71",
      "user_id":"2",
      "artwork":"http:\/\/s.pixogs.com\/image\/R-5363966-1391651135-9901.jpeg",
      "artist":"Grandbrothers",
      "title":"Ezra EP",
      "label":"Film",
      "genre":"Electronic",
      "price":"20.95",
      "country":"Germany",
      "size":"12",
      "count":"1",
      "color":"#000000",
      "type":"release",
      "notes":"",
      "created_at":"2014-08-24 21:53:53",
      "updated_at":"2014-08-24 21:53:53",
      "releasedate":"03 Feb 2014",
      "releasetype":"EP",
      "catno":"FILM001",
      "weight":"230"
    }
  ]
}
        </code></pre></li>
      </ul>
    </div>

    <!-- Vinyl -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><strong>Vinyl</strong></h3>
      </div>
      <div class="panel-body">
        Retreive information about a vinyl.
      </div>
      <!-- List group -->
      <ul class="list-group">
        <li class="list-group-item"><strong>Endpoint</strong> <br> <code>GET api/vinyl/&lt;id&gt;</code></li>
        <li class="list-group-item"><strong>Example</strong> <br> <kbd>curl -i http://beta.diskollect.com/api/vinyl/79</kbd></li>
        <li class="list-group-item"><strong>Response</strong> <br> <pre><code class="json">HTTP/1.1 200 OK
Content-Type: application/json
Cache-Control: no-cache

{
  "error":false,
  "message":200,
  "vinyl": {
    "id":"79",
    "user_id":"2",
    "artwork":"http:\/\/upload.wikimedia.org\/wikipedia\/en\/0\/0a\/Mike_oldfield_qe2_album_cover.jpg",
    "artist":"Mike Oldfield",
    "title":"QE2",
    "label":"Virgin",
    "genre":"Rock",
    "price":"4.50",
    "country":"France",
    "size":"12",
    "count":"1",
    "color":"#000000",
    "type":"release",
    "notes":"",
    "created_at":"2014-09-06 16:28:15",
    "updated_at":"2014-09-06 16:28:15",
    "releasedate":"1980",
    "releasetype":"EP",
    "catno":"202967",
    "weight":"230"},
    "tracks":[
      {
        "id":"66",
        "vinyl_id":"79",
        "artist_id":"1",
        "number":"A1",
        "artist":"Mike Oldfield",
        "title":"Taurus 1",
        "duration":"10:17",
        "created_at":"2014-09-06 16:28:15",
        "updated_at":"2014-09-06 16:28:15"
      },
      {
        "id":"67",
        "vinyl_id":"79",
        "artist_id":"1",
        "number":"A2",
        "artist":"Mike Oldfield",
        "title":"Sheba",
        "duration":"3:32",
        "created_at":"2014-09-06 16:28:15",
        "updated_at":"2014-09-06 16:28:15"
      },
      {
        "id":"68",
        "vinyl_id":"79",
        "artist_id":"1",
        "number":"A3",
        "artist":"Mike Oldfield",
        "title":"Conflict",
        "duration":"2:48",
        "created_at":"2014-09-06 16:28:15",
        "updated_at":"2014-09-06 16:28:15"
      },
      {
        "id":"69",
        "vinyl_id":"79",
        "artist_id":"1",
        "number":"A4",
        "artist":"Mike Oldfield",
        "title":"Arrival",
        "duration":"2:45",
        "created_at":"2014-09-06 16:28:15",
        "updated_at":"2014-09-06 16:28:15"
      },
      {
        "id":"70",
        "vinyl_id":"79",
        "artist_id":"1",
        "number":"B1",
        "artist":"Mike Oldfield",
        "title":"Wonderful Land",
        "duration":"3:37",
        "created_at":"2014-09-06 16:28:15",
        "updated_at":"2014-09-06 16:28:15"
      },
      {
        "id":"71",
        "vinyl_id":"79",
        "artist_id":"1",
        "number":"B2",
        "artist":"Mike Oldfield",
        "title":"Mirage",
        "duration":"4:39",
        "created_at":"2014-09-06 16:28:15",
        "updated_at":"2014-09-06 16:28:15"
      },
      {
        "id":"72",
        "vinyl_id":"79",
        "artist_id":"1",
        "number":"B3",
        "artist":"Mike Oldfield",
        "title":"QE2 \/ QE2 Finale",
        "duration":"7:39",
        "created_at":"2014-09-06 16:28:15",
        "updated_at":"2014-09-06 16:28:15"
      },
      {
        "id":"73",
        "vinyl_id":"79",
        "artist_id":"1",
        "number":"B4",
        "artist":"Mike Oldfield",
        "title":"Celt",
        "duration":"3:04",
        "created_at":"2014-09-06 16:28:15",
        "updated_at":"2014-09-06 16:28:15"
      },
      {
        "id":"74",
        "vinyl_id":"79",
        "artist_id":"1",
        "number":"B5",
        "artist":"Mike Oldfield",
        "title":"Molly",
        "duration":"1:13",
        "created_at":"2014-09-06 16:28:15",
        "updated_at":"2014-09-06 16:28:15"
      }
    ]
  }
}
</code></pre></li>
      </ul>
    </div>

    <!-- Track -->
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><strong>Track</strong></h3>
      </div>
      <div class="panel-body">
        Retreive information about a track.
      </div>
      <!-- List group -->
      <ul class="list-group">
        <li class="list-group-item"><strong>Endpoint</strong> <br> <code>GET api/track/&lt;id&gt;</code></li>
        <li class="list-group-item"><strong>Example</strong> <br> <kbd>curl -i http://beta.diskollect.com/api/vinyl/1</kbd></li>
        <li class="list-group-item"><strong>Response</strong> <br> <pre><code class="json">HTTP/1.1 200 OK
Content-Type: application/json
Cache-Control: no-cache

{
  "error":false,
  "message":200,
  "track":{
    "id":"1",
    "vinyl_id":"70",
    "artist_id":"1",
    "number":"A1",
    "artist":"Daft Punk",
    "title":"Give Life Back To Music",
    "duration":"4:35",
    "created_at":"2014-08-24 21:53:02",
    "updated_at":"2014-08-24 21:53:02"
  }
}
</code></pre></li>
      </ul>
    </div>
  </div>
@stop

@section('scripts')
  <script>hljs.initHighlightingOnLoad();</script>
@stop