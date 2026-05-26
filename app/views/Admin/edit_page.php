
<style>
    .note-editor.note-frame {
    border: 1px solid #ddd !important;
}

.note-toolbar {
    background: #f8f9fa !important;
    display: flex !important;
    flex-wrap: wrap;
}

.note-btn {
    color: #000 !important;
    background: #fff !important;
    border: 1px solid #ccc !important;
}
</style>
 <div class="d-flex justify-content-center align-items-center mt-5" > 
                           <form class="w-75 p-4 mx-auto rounded border border-2" enctype="multipart/form-data" action="index.php?page=update_page&id=<?= $page['id'] ?>" method="post">
    <div class="top w-100 rounded-top">
        <h3 class="text-center text-white mb-4">Edit Pages</h3>
    </div>
    <div class="row">
     <div class="col-12">   
 <input type="hidden" name="id" value="<?php echo htmlspecialchars($page['id']); ?>">
    <div class="mb-3">
        <label for="pname" class="form-label">Title</label>
        <input type="text" name="title" id="pname" class="form-control" value="<?= $page['title']; ?>" />
    </div>


    <div class="mb-3">
<textarea id="content" name="content"><?= $page['content']; ?></textarea>
   


</div>

</div>

  <div class="col-lg-12 col-sm-6"> 
    <h3 class="text-center text-white bg-success mb-4">Add Meta Info</h3>

    <div class="mb-3">
        <label for="meta-title" class="form-label">Meta Title</label>
        <textarea class="form-control" name="meta_title" id="meta-title" rows="3" ><?= $page['meta_title']; ?></textarea>
    </div>

    <div class="mb-3">
        <label for="meta-description" class="form-label">Meta Description</label>
        <textarea class="form-control" name="meta_desc" id="meta-description" rows="3"><?= $page['meta_description']; ?></textarea>
    </div>

    <div class="mb-3">
        <label for="meta-keyword" class="form-label">Meta Keywords</label>
        <textarea class="form-control" name="meta_keywords" id="meta-keyword" rows="3" ><?= $page['meta_keywords']; ?></textarea>
    </div>

    <div class="text-center">
        <button type="submit" name="update" class="btn" id="mbut">Save Chnages</button>
    </div>
</form>

                        </div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>
<script>
$(document).ready(function () {
    $('#content').summernote({
        height: 300,
        placeholder: 'Write page content here...',
    toolbar: [
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['insert', ['link', 'picture']],
    ['view', ['codeview', 'fullscreen']]
]
    });
});
</script>
