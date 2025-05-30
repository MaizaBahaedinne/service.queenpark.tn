<div class="content-wrapper">
  <section class="content-header">
    <div style="display: flex; align-items: center; gap: 15px;">
      <div>
        <h2 style="margin: 0;">
          <i class="fa fa-tachometer"></i> Modification de mot de passe
        </h2>
        <small>
          pour l'utilisateur <strong><?php echo $user->name; ?></strong>
        </small>
      </div>
    </div>
  </section>

  <section class="content">

    <?php if ($this->session->flashdata('success')): ?>
          <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('error')): ?>
          <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>
        
    <div class="row">
      <div class="col-lg-6 col-xs-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Nouveau mot de passe</h3>
          </div>
          <form action="<?php echo base_url('User/updatePassword/'.$user->userId); ?>" method="post" onsubmit="return checkPasswordsMatch();">
            <div class="box-body">
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
</script>
