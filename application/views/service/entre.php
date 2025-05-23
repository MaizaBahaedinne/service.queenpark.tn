div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Tableau de bord
        <small>Queen Park Services</small>
      </h1>
    </section>
     
    <section class="content">
       <div class="row">
            <div class="col-lg-3 col-xs-6">

              <form method="post" action="/entrees/save_multiple" class="form-style">
                <div id="entree-container">
                  <div class="entree-row">
                    <div class="row">
                      <div class="col">
                        <label>Quantité</label>
                        <input type="number" name="quantite[]" required>
                      </div>
                      <div class="col">
                        <label>Nature</label>
                        <input list="natures" name="nature[]" placeholder="Ex: Jus, Gâteau..." required>
                      </div>
                      <div class="col">
                        <label>Moment</label>
                        <select name="moment_service[]" required>
                          <option value="">-- Choisir --</option>
                          <option value="debut">Début</option>
                          <option value="diner">Dîner</option>
                          <option value="milieu">Milieu</option>
                          <option value="fin">Fin</option>
                        </select>
                      </div>
                      <div class="col">
                        <label>Note</label>
                        <input type="text" name="note[]">
                      </div>
                      <div class="col delete-col">
                        <button type="button" class="remove-btn">X</button>
                      </div>
                    </div>
                  </div>
                </div>

                <datalist id="natures"></datalist>

                <div class="form-buttons">
                  <button type="button" id="add-row">+ Ajouter une ligne</button>
                  
                  <button type="submit">Enregistrer</button>
                </div>
              </form>
            </div>
          </div>
        </section>

