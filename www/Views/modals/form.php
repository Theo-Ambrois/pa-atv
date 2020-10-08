<?php $inputData = $GLOBALS["_".strtoupper($data["config"]["method"])]; ?>
<!--
   Génération de formulaire automatique
 -->
<form
method="<?= $data["config"]["method"]?>" 
action="<?= $data["config"]["action"]?>"
id="<?= $data["config"]["id"]?>"
class="<?= $data["config"]["class"]?>">

    <!-- forEach pour chaque fields présent dans le formulaire -->
    <?php foreach ($data["fields"] as $name => $configField):?>
    <div class="row">
        <div class="col-12">

            <!-- Création du captcha -->
            <?php if($configField["type"] == "captcha"): ?>
                <img src="script/captcha.php" width="300px">
                <br><br>
            <?php endif ?>

            <!-- Insertion d'un selecteur si présent -->
            <?php if ($configField["type"] == 'select'): ?>
                <select name="<?= $name??'' ?>"
                        id="<?= $configField["id"]??'' ?>"
                        class="<?= $configField["class"]??'' ?>">
                    <?php foreach ($configField['options'] as $k => $v): ?>
                        <option value="<?= $k ?>"><?= $v ?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif ?>

            <!-- Insertion de checkbox -->
            <?php if ($configField["type"] === "checkBox_Auth"): ?>
                <div>
                    <?= ucfirst($name) ?> :
                    <?php foreach ($configField["options"] as $k => $v): ?>
                        <label><?= $v ?></label>
                        <input type="checkbox" name="<?= $k ?>"
                            <?php if (isset($editData) && isset($editData[$k])) {
                                if ($editData[$k]) echo 'checked';
                            } ?>>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Insertion des champs autre que de type select et checkbox -->
            <?php if ($configField["type"] !== 'select' && $configField["type"] !== "checkBox_Auth"): ?>
                <input
                    value="<?php if (isset($inputData[$name]) && $configField['type']!='password') {  echo $inputData[$name]; }
                               elseif((isset($editData))) { echo $editData[$name];}
                               else echo ''; ?>"
                    type="<?= $configField["type"]??'' ?>"
                    name="<?= $name??'' ?>"
                    placeholder="<?= $configField["placeholder"]??'' ?>"
                    class="<?= $configField["class"]??'' ?>"
                    id="<?= $configField["id"]??'' ?>"
                    <?=(!empty($configField["required"]))?"required='required'":""?> >
            <?php endif ?>

        </div>
    </div>
    <?php endforeach;?>


  <div class="row justify-content-center">
    <button class="button"><?= $data["config"]["submit"];?></button>
  </div>
  
</form>
