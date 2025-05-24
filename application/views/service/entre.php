<style>
  


.form-style {
  background: white;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.1);
  max-width: 1000px;
  margin: auto;
}

.entree-row {
  border: 1px solid #ccc;
  padding: 15px;
  margin-bottom: 10px;
  border-radius: 8px;
  background-color: #fafafa;
}

.row {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.col {
  flex: 1;
  min-width: 150px;
  display: flex;
  flex-direction: column;
}

input, select, button {
  padding: 8px;
  margin-top: 5px;
  font-size: 14px;
}

button {
  cursor: pointer;
}

.delete-col {
  display: flex;
  align-items: end;
}

.remove-btn {
  background-color: #e74c3c;
  color: white;
  border: none;
  padding: 6px 10px;
  border-radius: 5px;
}

.form-buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

#add-row {
  background-color: #3498db;
  color: white;
  border: none;
  padding: 8px 15px;
  border-radius: 5px;
}


</style>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <i class="fa fa-tachometer" aria-hidden="true"></i> Gestion des entrées 
        <small>Ajout des entrée pour l'évenement de <?php echo $reservation->dateFin ?> à  <?php echo $reservation->salle ?> </small>
      </h1>
    </section>
     
    <section class="content">
       <div class="row">
            <div class="col-lg-12 col-xs-12">

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
      </div>



      <script type="text/javascript">
        const naturesExistantes = [
              "Jus", "Eau", "Pâtisserie", "Gâteau", "Salé", "Boisson gazeuse", "Thé", "Café", "Snack", "Fruit"
            ];

            // Remplir datalist
            const datalist = document.getElementById("natures");
            naturesExistantes.forEach(nature => {
              const option = document.createElement("option");
              option.value = nature;
              datalist.appendChild(option);
            });

            // Ajouter ligne
            document.getElementById('add-row').addEventListener('click', () => {
              const container = document.getElementById('entree-container');
              const firstRow = container.querySelector('.entree-row');
              const clone = firstRow.cloneNode(true);
              clone.querySelectorAll('input, select').forEach(input => input.value = '');
              container.appendChild(clone);
            });

            // Supprimer ligne
            document.addEventListener('click', function (e) {
              if (e.target && e.target.classList.contains('remove-btn')) {
                const rows = document.querySelectorAll('.entree-row');
                if (rows.length > 1) {
                  e.target.closest('.entree-row').remove();
                }
              }
            });

      </script>

