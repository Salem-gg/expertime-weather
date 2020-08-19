<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/Salem-gg
 * @since      1.0.0
 *
 * @package    Expertime_Weather
 * @subpackage Expertime_Weather/admin/partials
 */
?>

<div class="container">
  <div class="row">
    <h1>Configuration de l'api</h1>
  </div>
  <div class="row">
    <div class="col">
      <form action="javascript:void()" id="frm-endpoint">
        <div class="form-group">
          <label for="endpoint">Configurez ici votre accès à l'api</label>
          <input type="text" class="form-control" id="frm-endpoint-input" name="endpoint-input" placeholder="endpoint" value="<?php if($endpoint != null) { echo($endpoint); } ?>" required>
        </div>
        <button type="submit" class="btn btn-primary" id="frm-endpoint-submit">Sauvegarder</button>
      </form>
    </div>
  </div>
</div>
