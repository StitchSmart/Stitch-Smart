
                       
                        <div class="d-flex justify-content-center align-items-center mt-5" > 
                      <form class="w-75 p-4 mx-auto rounded border border-2" action="<?php echo BASE_URL ?>index.php?page=edit_banner&id=<?php echo $banner['id']; ?>" method="POST" enctype="multipart/form-data">
   <div class="top w-100 rounded-top">
                                <h3 class="text-center text-white mb-4">Edit Banner</h3>
                            </div>
                             <div class="mb-3">
                                    <label for="text" class="form-label">Banner Name</label>
<input type="text" name="text" class="form-control" value="<?php echo $banner['alt']; ?>">

</div>
   <div class="mb-3">
                                    <label for="text" class="form-label">Text</label>
<textarea type="text" name="alt" class="form-control" rows="3" ><?php echo $banner['text']; ?></textarea>
</div>


 <div class="mb-3">
                                    <label for="image" class="form-label">Banner Image</label>

<input type="file" name="bimage" class="form-control" placeholder="upload image" >
</div>
<div class="text-center">

<button type="submit" name="updatebanner" class="btn" id="mbut">Update Banner</button>
</div>
</form>    
                        </div>
                            
             