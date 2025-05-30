<div class="content-wrapper">
  <section class="content-header">
    <div style="display: flex; align-items: center; gap: 15px;">
      <div>
        <h2 style="margin: 0;">
          <i class="fa fa-tachometer"></i> Modification de mot de passe
        </h2>
        <small>
          pour l'utilisateur <strong><?php echo htmlspecialchars($user->name); ?></strong>
        </small>
      </div>
    </div>
  </section>

  <section class="content">

    <?php if ($this->session->flashdata('success')): ?>
      <div class="alert alert-success"><?= htmlspecialchars($this->session->flashdata('success')) ?></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($this->session->flashdata('error')) ?></div>
    <?php endif; ?>

    <div class="row">
      <div class="col-lg-6 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Nouveau mot de passe & avatar</h3>
          </div>

          <form action="<?php echo base_url('User/updatePassword/'.$user->userId); ?>" method="post" onsubmit="return checkPasswordsMatch();">
            <div class="box-body">
              <div style="margin-bottom: 20px;">
                <label>Avatar actuel :</label><br>
                <?php if (!empty($user->avatar)): ?>
                  <img src="data:image/jpeg;base64,<?php echo $user->avatar; ?>" alt="Avatar" style="width:100px; height:100px; border-radius:50%; object-fit: cover; border: 2px solid #666;">
                <?php else: ?>
                  <div style="width:100px; height:100px; border-radius:50%; background:#ccc; display:flex; align-items:center; justify-content:center; font-size: 48px; color:#999;">👤</div>
                <?php endif; ?>
              </div>

              <div class="form-group">
                <label for="avatar">Modifier avatar (format PNG/JPG, max 2MB compressé)</label>
                <input type="file" id="avatar" accept="image/png, image/jpeg" onchange="encodeImageFileAsURL(this)">
                <input type="hidden" name="avatar_base64" id="avatar_base64">
                <div id="avatar_preview" style="margin-top: 10px;"></div>
              </div>

              <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control" required minlength="6" placeholder="Nouveau mot de passe">
              </div>
              <div class="form-group">
                <label for="confirm_password">Confirmer le mot de passe</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required minlength="6" placeholder="Confirmer le mot de passe">
              </div>
              <div id="error-message" style="color: red; display: none;">❌ Les mots de passe ne correspondent pas.</div>
            </div>

            <div class="box-footer">
              <button type="submit" class="btn btn-success">
                <i class="fa fa-save"></i> Enregistrer
              </button>
              <a href="<?php echo base_url('User/list'); ?>" class="btn btn-default">
                <i class="fa fa-arrow-left"></i> Retour
              </a>
            </div>
          </form>

        </div>
      </div>
    </div>

  </section>
</div>

<script>
  function checkPasswordsMatch() {
    const pwd = document.getElementById('password').value;
    const confirmPwd = document.getElementById('confirm_password').value;
    if (pwd !== confirmPwd) {
      document.getElementById('error-message').style.display = 'block';
      return false;
    }
    return true;
  }

  function encodeImageFileAsURL(input) {
    const file = input.files[0];
    if (!file) return;

    if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
      alert("Format non supporté, mets un PNG ou JPG stp.");
      input.value = '';
      return;
    }

    if (file.size > 5 * 1024 * 1024) { // 5MB max avant compression
      alert("Fichier trop lourd, max 5MB avant compression.");
      input.value = '';
      return;
    }

    const reader = new FileReader();
    reader.onload = function(event) {
      const img = new Image();
      img.onload = function() {
        const canvas = document.createElement('canvas');
        const maxWidth = 800;
        const maxHeight = 800;
        let width = img.width;
        let height = img.height;

        if (width > maxWidth || height > maxHeight) {
          if (width > height) {
            height = Math.round(height * (maxWidth / width));
            width = maxWidth;
          } else {
            width = Math.round(width * (maxHeight / height));
            height = maxHeight;
          }
        }

        canvas.width = width;
        canvas.height = height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0, width, height);

        const compressedDataUrl = canvas.toDataURL('image/jpeg', 0.7);

        const base64data = compressedDataUrl.split(',')[1];

        const byteLength = (base64data.length * (3/4));

        if (byteLength > 2 * 1024 * 1024) {
          alert("L’image compressée est toujours trop lourde (> 2MB), choisis une autre photo ou réduis la résolution.");
          input.value = '';
          document.getElementById('avatar_preview').innerHTML = '';
          document.getElementById('avatar_base64').value = '';
          return;
        }

        document.getElementById('avatar_base64').value = base64data;
        document.getElementById('avatar_preview').innerHTML = `<img src="${compressedDataUrl}" style="width:100px; height:100px; border-radius:50%; object-fit: cover; border: 2px solid #666;">`;
      };
      img.src = event.target.result;
    };
    reader.readAsDataURL(file);
  }
</script>
