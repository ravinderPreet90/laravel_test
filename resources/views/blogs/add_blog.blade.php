
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<div class="container">
    <h1>Add blogs</h1>
    <div class="text-right mb-3"><a href="logout" class=" btn-primary btn">Logout</a></div>
<form action="{{route('save_blog')}}" method="post" enctype="multipart/form-data">
  @csrf
  <div class="form-group">
    <label for="exampleFormControlInput1">Blog title</label>
    <input type="text" name="title" class="form-control" id="exampleFormControlInput1" required>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Blog description</label>
    <textarea class="form-control" name="description" required></textarea>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect2">Blog image</label>
    <input type="file" name="blog_image" required>
  </div>
  <div class="form-group">
    <button type="submit" class="form-control btn-primary">Add blog</button>
</div>
  
</form>
</div>
<style>
 .container{
 
  background-color: #e0d7d7;
}
      
  </style>