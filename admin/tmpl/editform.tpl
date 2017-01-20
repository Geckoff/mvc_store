<h2><?=$this->h2_editform_title ?></h2>
<form action="<?= $this->adminfunction_url ?>" <?php if ($this->file_form) echo "enctype = 'multipart/form-data'"?> method='post' id='editform'>
    <?php for ($i = 0; $i < count($this->edit_form_string); $i++) { ?>         
         <div class="input-string">
            <?php if ($this->edit_form_string[$i]['type'] == 'text' || $this->edit_form_string[$i]['type'] == 'password' || $this->edit_form_string[$i]['type'] == 'date') {?>
                <span class="input-name"><?=$this->edit_form_string[$i]['input_title'] ?></span><input type="<?=$this->edit_form_string[$i]['type'] ?>" name="<?=$this->edit_form_string[$i]['input_name']?>" value="<?=$this->edit_form_string[$i]['input_value']?>" />
            <?php }
            elseif ($this->edit_form_string[$i]['type'] == 'file') {?>
                <span class="input-name"><?=$this->edit_form_string[$i]['input_title'] ?></span><input type="<?=$this->edit_form_string[$i]['type'] ?>" name="<?=$this->edit_form_string[$i]['input_name']?>"  />
            <?php }
            elseif ($this->edit_form_string[$i]['type'] == 'checkbox') {?>
                <span class="input-name"><?=$this->edit_form_string[$i]['input_title'] ?></span><input type="<?=$this->edit_form_string[$i]['type'] ?>" name="<?=$this->edit_form_string[$i]['input_name']?>" value="1" <?php if ($this->edit_form_string[$i]['input_value'] == 1) echo 'checked' ?> />
            <?php }
            elseif ($this->edit_form_string[$i]['type'] == 'textarea') {?>
                <span class="input-name"><?=$this->edit_form_string[$i]['input_title'] ?></span><textarea name="<?=$this->edit_form_string[$i]['input_name']?>" id="" cols="30" rows="10"><?=$this->edit_form_string[$i]['input_value']?></textarea>
            <?php }
            elseif ($this->edit_form_string[$i]['type'] == 'hidden') {?>
                <input type="<?=$this->edit_form_string[$i]['type']?>" name="<?=$this->edit_form_string[$i]['input_name']?>" value="<?=$this->edit_form_string[$i]['input_value']?>" />
            <?php }
            elseif ($this->edit_form_string[$i]['type'] == 'submit') {?>
                <input type="<?=$this->edit_form_string[$i]['type']?>" name="<?=$this->edit_form_string[$i]['input_name']?>" value="<?=$this->edit_form_string[$i]['input_title']?>" />
            <?php }
            elseif ($this->edit_form_string[$i]['type'] == 'select') {?>
                <span class="input-name"><?=$this->edit_form_string[$i]['input_title'] ?></span>
                <select name="<?=$this->edit_form_string[$i]['input_name']['selectname'] ?>">
                    <?php foreach ($this->edit_form_string[$i]['input_name'] as $value => $title) { ?>
                        <?php if ($value == 'selectname') continue; ?>
                        <option value="<?=$value?>" <?php if ($value == $this->edit_form_string[$i]['input_value']) echo 'selected="selected"' ?>><?=$title?></option>
                    <?php } ?>
                </select>
            <?php }
             elseif ($this->edit_form_string[$i]['type'] == 'spec') {?>
                <?php if ($this->edit_form_string[$i]['input_title'] != '') { ?>
                    <span class="input-name"><?=$this->edit_form_string[$i]['input_title'] ?></span>
                <?php } ?>
                <?php if ($this->edit_form_string[$i]['change_elem'] != '') {
                    echo preg_replace($this->edit_form_string[$i]['change_elem'], $this->edit_form_string[$i]['input_value'], $this->edit_form_string[$i]['show_this']);
                }
                else echo $this->edit_form_string[$i]['show_this']?>
            <?php } ?>
         </div>
    <?php } ?>
</form>
<span style='color: red'><?=$this->air_message ?></span>