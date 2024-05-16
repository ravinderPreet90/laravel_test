<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Document</title>
    <style>
         .blog-post {
    margin-bottom: 30px;
    border-bottom: 1px solid #ccc;
    padding-bottom: 20px;
    overflow: hidden;
  }

  .blog-post img {
    float: left;
    margin-right: 20px;
    width: 200px; /* Adjust size as needed */
    height: auto; /* Maintain aspect ratio */
  }

  .blog-post h2 {
    font-size: 24px;
    margin-top: 0;
  }

  .blog-post p {
    font-size: 16px;
    line-height: 1.6;
  }

  .like-icon {
    color: #ccc;
    margin-right: 10px;
    cursor: pointer;
  }

  .like-icon:hover {
    color: #ff5733; /* Adjust color for hover effect */
  }
  .pagination {
    display: inline-block;
  }

  .pagination a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
    border: 1px solid #ddd;
    margin: 0 4px;
  }

  .pagination a.active {
    background-color: #4CAF50;
    color: white;
    border: 1px solid #4CAF50;
  }

  .pagination a:hover:not(.active) {background-color: #ddd;}

  .comment-section {
    margin-top: 30px;
  }

  .comment {
    margin-bottom: 20px;
  }

  .comment-author {
    font-weight: bold;
    margin-bottom: 5px;
  }

  .comment-content {
    margin-left: 20px;
  }

  .comment-input {
    width: 100%;
    margin-bottom: 10px;
  }

  .comment-button {
    padding: 8px 16px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  .comment-button:hover {
    background-color: #0056b3;
  }
  </style>
</head>
<body>
    <div class="container">
    <div class="text-right mb-3"><a href="logout" class=" btn-primary btn">Logout</a></div>
        <div class="row">
            @if(!empty($blogs))
            @foreach($blogs as $blog)
            <div class="blog-post">

                <img src="{{url('/images').'/'.$blog['image']}}" alt="Blog Post Image">
                <a href="{{route('blog_detail',$blog['id'])}}"> <h2>{{$blog['title']}}</h2></a>
                <p>{{$blog['description']}}</p>
                <div class="like-comment">
                <span class="like-icon" attr_blog_id="{{$blog['id']}}">&#x2661;<p class="count-{{$blog['id']}}">{{count($blog['blog_like'])}}</p> </span> <!-- Heart icon for like -->
                <span class="comment" attr_blog_id="{{$blog['id']}}"><p class="comment-count-{{$blog['id']}}">{{count($blog['blog_comment'])}}</p>comment</span>
                <form class="comment-form-{{$blog['id']}}" id="comment-form-{{$blog['id']}}" atrr_blog_id="{{$blog['id']}}" method="post" style="display:none">
                    @csrf
                    <input type="text" class="comment_text" name="comment">
                    <input type="hidden" value="{{$blog['id']}}" name="blog_id">
                    <button  class="submit-comment">Add comment</button>
                </form>
        </div>
                <!-- Add more like icons or other actions as needed -->
            </div>

            @endforeach

            @else
            <p>No blogs added</p>
            @endif



            </div>

<div class="col-sm-6">
</div>

<div class="pagination">



    <!-- pagination -->
</a>
@if(!empty($blogs))
<?php $c = "active";?>
@for($i=1;$i<=$blogs->lastPage();$i++)

    <?php
if (isset($_GET['page']) && $_GET['page'] == $i) {
    $c = "active";
} else {
    $c = "";
}?>
    <a class="{{$c}}" href="{{$blogs->url($i)}}">{{$i}}</a>
@endfor

</a>
</div>
@endif

<!-- <div class="comment-section">
  <div class="comment">
    <div class="comment-author">John Doe</div>
    <div class="comment-content">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
  </div>
  <div class="comment">
    <div class="comment-author">Jane Smith</div>
    <div class="comment-content">Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
  </div> -->

  <!-- Add more comments here -->

  <!-- <input type="text" class="comment-input" placeholder="Add a comment...">
  <button class="comment-button">Post Comment</button>
</div>
</div>
</div> -->
<script>
    $(document).ready(function(){
        $(document).on("click",".like-icon",function() {
            var blog_id=$(this).attr('attr_blog_id');
            $.ajax({
                type: 'POST',
                url: '<?php echo route('blog_like') ?>',
                data: {'blog_id':blog_id},
                dataType: 'json',
                success: function(response) {
                    $('.count-'+blog_id).text(response);
                    // Handle the response message
                   // $('#cf-response-message').text(response.message);
                },
                error: function(xhr, status, error) {
                    // Handle errors if needed
                  //  console.error(xhr.responseText);
                }
            });
    });
    $(document).on("click",".comment",function() {
        var blog_id=$(this).attr('attr_blog_id');
        $('.comment-form-'+blog_id).show();
    })
    $(document).on("click",".submit-comment",function() {
       var form_id= $(this).closest('form').attr('id');
       var form_data=$('#'+form_id).serialize();
       var blog_id= $(this).closest('form').attr('atrr_blog_id');;


       $.ajax({
                type: 'POST',
                url: '<?php echo route('blog_comment') ?>',
                data: form_data,
                dataType: 'json',
                success: function(response) {
                    $('.comment-form-'+blog_id).hide();
                    $('.comment-count-'+blog_id).text(response);
                    // Handle the response message
                   // $('#cf-response-message').text(response.message);
                },
                error: function(xhr, status, error) {
                    // Handle errors if needed
                  //  console.error(xhr.responseText);
                }
            });
            return false;

    })
    })
    </script>
</body>
</html>