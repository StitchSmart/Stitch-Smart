
                       
                        <div class="d-flex justify-content-center align-items-center mt-5" > 
   <style>
        .form-control.is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.15rem rgba(220, 53, 69, 0.25);
            background: rgba(220, 53, 69, 0.06);
        }
        .form-control.is-invalid::placeholder {
            color: #b02a37 !important;
            opacity: 1 !important;
            font-weight: 600;
        }
        .invalid-feedback-custom {
            color: #c92a2a;
            font-size: 0.95rem;
            margin-top: 0.25rem;
            display: block;
        }
    </style>

    <?php if (!empty($_SESSION['errors']) && is_array($_SESSION['errors'])): ?>
        <div class="alert alert-danger">
            <strong>Fix the highlighted fields below.</strong>
        </div>
    <?php endif; ?>

                      <form class="w-75 p-4 mx-auto rounded border border-2" action="<?php echo BASE_URL ?>index.php?page=banner_add" method="POST" enctype="multipart/form-data" novalidate>
   <div class="top w-100 rounded-top">
                                <h3 class="text-center text-white mb-4">Add Banner</h3>
                            </div>
                             <div class="mb-3">
                                    <label for="text" class="form-label">Banner Name</label>
<input type="text" name="text" id="text" placeholder="<?= isset($_SESSION['errors']['text']) ? htmlspecialchars($_SESSION['errors']['text']) : 'Banner Text' ?>" class="form-control <?= isset($_SESSION['errors']['text']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($_SESSION['old_input']['text'] ?? '') ?>" required>
<?php if(isset($_SESSION['errors']['text'])): ?>
    <span class="invalid-feedback-custom"><?= htmlspecialchars($_SESSION['errors']['text']) ?></span>
<?php endif; ?>
</div>
   <div class="mb-3">
                                    <label for="alt" class="form-label">Text</label>
<textarea name="alt" id="alt" class="form-control <?= isset($_SESSION['errors']['alt']) ? 'is-invalid' : '' ?>" rows="3" placeholder="<?= isset($_SESSION['errors']['alt']) ? htmlspecialchars($_SESSION['errors']['alt']) : 'Enter text to be displayed' ?>" required><?= htmlspecialchars($_SESSION['old_input']['alt'] ?? '') ?></textarea>
<?php if(isset($_SESSION['errors']['alt'])): ?>
    <span class="invalid-feedback-custom"><?= htmlspecialchars($_SESSION['errors']['alt']) ?></span>
<?php endif; ?>
</div>


 <div class="mb-3">
                                    <label for="image" class="form-label">Banner Image</label>

<input type="file" name="bimage" id="image" class="form-control <?= isset($_SESSION['errors']['bimage']) ? 'is-invalid' : '' ?>" required>
<?php if(isset($_SESSION['errors']['bimage'])): ?>
    <span class="invalid-feedback-custom d-block"><?= htmlspecialchars($_SESSION['errors']['bimage']) ?></span>
<?php endif; ?>
<div class="text-center">

<button type="submit" name="addbanner" class="btn" id="mbut">Add Banner</button>
</div>
</form>
<?php unset($_SESSION['errors'], $_SESSION['old_input']); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action="<?php echo BASE_URL ?>index.php?page=banner_add"]');
    if (!form) return;
    const nameField = document.getElementById('text');
    const altField = document.getElementById('alt');
    const fileField = document.getElementById('image');

    form.addEventListener('submit', function(event) {
        let valid = true;

        [nameField, altField].forEach(field => {
            field.classList.remove('is-invalid');
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                field.placeholder = 'Fill this field.';
                field.value = '';
                valid = false;
            }
        });

        fileField.classList.remove('is-invalid');
        if (!fileField.value) {
            fileField.classList.add('is-invalid');
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
            document.querySelector('.is-invalid')?.focus();
        }
    });
});
</script>
                        </div>
                            
                    </div>   
          