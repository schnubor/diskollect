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
  "user": {
    "id":1,
    "email":"schnuppser@gmail.com",
    "username":"schnubor",
    "name":"Christian Kornd\u00f6rfer",
    "website":"http:\/\/www.diskollect.com",
    "location":"Berlin, Germany",
    "image":"https:\/\/scontent-b.xx.fbcdn.net\/hphotos-xfa1\/t1.0-9\/319966_539177582772097_855047788_n.jpg",
    "description":
    "Berlin, 27",
    "active":1,
    "discogs_uri":"",
    "created_at":"-0001-11-30 00:00:00",
    "updated_at":"2014-08-17 10:47:59",
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
        <li class="list-group-item"><strong>Example</strong> <br> <kbd>curl -i http://beta.diskollect.com/api/collection/1</kbd></li>
        <li class="list-group-item"><strong>Response</strong> <br> <pre><code class="json">HTTP/1.1 200 OK
Content-Type: application/json
Cache-Control: no-cache

{
  "error":false,
  "message":200,
  "collection":[
    {
      "id":3,
      "user_id":1,
      "artwork":"http:\/\/lorempixel.com\/600\/600\/cats\/",
      "artist":"Kira Carter",
      "title":"Maiores modi architecto.",
      "label":"exercitationem",
      "genre":"Jazz",
      "price":8.4700002670288,
      "country":"IE",
      "size":7,
      "count":1,
      "color":"#576f90",
      "type":"release",
      "notes":"Blanditiis rerum non sunt aut quasi.",
      "created_at":"2014-08-24 12:10:10",
      "updated_at":"2014-08-24 12:10:10",
      "releasedate":"1985-08-09",
      "releasetype":"RE",
      "catno":"fm 0387",
      "weight":"436"
    },
    {
      "id":4,
      "user_id":1,
      "artwork":"http:\/\/lorempixel.com\/600\/600\/cats\/",
      "artist":"Mr. Camden Kuhlman IV",
      "title":"Illo dolore eaque.",
      "label":"neque",
      "genre":"Hip Hop",
      "price":9.3100004196167,
      "country":"FR",
      "size":10,
      "count":2,
      "color":"#c6caa3",
      "type":"release",
      "notes":"Inventore aut est quia fugiat quasi autem.",
      "created_at":"2014-08-24 12:10:10",
      "updated_at":"2014-08-24 12:10:10",
      "releasedate":"1975-09-04",
      "releasetype":"RE",
      "catno":"og 7474",
      "weight":"187"
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
    "id":1,
    "vinyl_id":23,
    "artist_id":14,
    "number":"11",
    "artist":"Ida Grant",
    "title":"Eum error.",
    "duration":"28:33",
    "created_at":"2014-08-24 12:10:10",
    "updated_at":"2014-08-24 12:10:10"
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