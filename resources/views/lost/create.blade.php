<h1>Report Lost Item</h1>

<form action="{{ route('lost.store') }}" method="POST" enctype="multipart/form-data">
  @csrf
  <input type="text" name="item_name" placeholder="Item Name"><br>
  <input type="text" name="category" placeholder="Category"><br>
  <input type="text" name="location_lost" placeholder="Where lost?"><br>
  <input type="date" name="date_lost"><br>
  <input type="file" name="photo"><br>
  <button type="submit">Submit</button>
</form>