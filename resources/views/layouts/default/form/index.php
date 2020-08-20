<form action="/" method="get">
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="amountFrom">Количество валюты для конвертации</label>
      <input type="number"
             class="form-control"
             id="amountFrom"
             name="amountFrom"
             value="<?= $amountFrom; ?>">
    </div>
    <div class="form-group col-md-4">
      <label for="amountTo">Количество валюты после конвертации</label>
      <input type="text"
             class="form-control"
             id="amountTo"
             value="<?= $amountTo; ?>"
             disabled>
    </div>
  </div>
  
  <div class="form-row">
    <div class="form-group col-md-4">
      <label for="from">Конвертировать из</label>
      <select id="from" class="form-control" name="from">
          <?php foreach ($currencies as $currency): ?>
            <option value="<?= $currency->bank_code; ?>"
                <?= $currency->bank_code == $selectedFrom ? 'selected' : ''; ?> >
                <?= $currency->name; ?>
            </option>
          <?php endforeach; ?>
      </select>
    </div>

    <div class="form-group col-md-4">
      <label for="to">Конвертировать в</label>
      <select id="to" class="form-control" name="to">
          <?php foreach ($currencies as $currency): ?>
            <option value="<?= $currency->bank_code; ?>"
                <?= $currency->bank_code == $selectedTo ? 'selected' : ''; ?> >
                <?= $currency->name; ?>
            </option>
          <?php endforeach; ?>
      </select>
    </div>
  </div>

  <div class="form-group row">
    <div class="col-sm-6">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" id="saveHistory" name="saveHistory">
        <label class="form-check-label" for="saveHistory">
          Занести в историю
        </label>
      </div>
    </div>
  </div>

  <div class="form-group row">
    <div class="col-sm-10">
      <button type="submit" class="btn btn-primary">Конвертировать</button>
    </div>
  </div>
</form>