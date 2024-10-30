<?php
if ( ! defined( 'ABSPATH' ) ) exit; // 

global $wpdb;
$table = $wpdb->prefix . 'messenger_button';
$sSQL = $wpdb->prepare("select * from $table ", 1);
$arrresult = $wpdb->get_results($sSQL);

wp_enqueue_style('messenger_style_css', plugin_dir_url(__FILE__) . 'style_xtz.css');
if (!$arrresult) {
    $arrresult = array(
        'viber' => (object)array(
            'title' => 'Viber',

            'placeholder' => '+380991231212',
            'code' => 'viber://chat?number=',
            'href' => '',
            'onclick' => '',
            'active' => 0
        ),
        'whatsapp' => (object)array(
            'title' => 'WhatsApp',

            'placeholder' => '380991231212',
            'code' => 'https://wa.me/',
            'href' => '',
            'onclick' => '',
            'active' => 0
        ),

    );

}


// check form

if ($_POST["socials"]) {

    if (!wp_verify_nonce($_POST['name_of_nonce_field'], 'name_of_my_action')) {
        echo 'Извините, проверочные данные не соответствуют.';
        die();
    } else {

        $data = [];
        foreach ($_POST["socials"] as $code => $soc) {

            $title = sanitize_title($soc['title']);

            $table = $wpdb->prefix . 'messenger_button';
            $sql = "SELECT * FROM $table WHERE title = '$title'";
            $result = $wpdb->get_row($sql);
            if ($result === null) {
                $data['title'] = sanitize_title($soc['title']);
                $data['code'] = sanitize_text_field($soc['code']);
                $data['href'] = sanitize_text_field($soc['href']);
                $data['onclick'] = sanitize_text_field($soc['onclick']);
                $data['active'] = (int)$soc['active'];

                $wpdb->insert($table, $data);
            } else {

                $data['title'] = sanitize_title ($soc['title']);
                $data['code'] = sanitize_text_field($soc['code']);
                $data['href'] = sanitize_text_field($soc['href']);
                $data['onclick'] = sanitize_text_field($soc['onclick']);
                $data['active'] = (int)$soc['active'];

                $wpdb->update($table, $data, array('id' => $soc['id']));
            }
        }
    }
}
$table = $wpdb->prefix . 'messenger_button_params';
$sSQL = $wpdb->prepare("select * from $table", 1);
$res_params = $wpdb->get_results($sSQL);


if (!$res_params) {

    $default_data = 'a:2:{s:8:"position";s:8:"right_center";s:13:"style_version";s:1:"1";}';
    $data = array('params' => $default_data);
    $wpdb->insert($table, $data);
}

if ($_POST["params"]) {

    if (!wp_verify_nonce($_POST['name_of_nonce_field'], 'name_of_my_action')) {
        echo 'Извините, проверочные данные не соответствуют.';
        die();
    } else {

        $params = array();
        foreach ($_POST["params"] as $key=>$param) {
            $params[$key] = sanitize_text_field($param);
        }
        $res_params = array('params' => serialize($params));
        $wpdb->update($table, $res_params, array('id' => 1));
        ?>
        <script>
            location.reload();
        </script>
    <?php }
}


?>


<div class="panel_xtz">
    <form action="/wp-admin/admin.php?page=<?=WPMB_PLUGIN_NAME;?>%2Fadmin%2Fform.php"
          method="post" class="defaultForm form-horizontal" enctype="multipart/form-data">
        <?php wp_nonce_field('name_of_my_action', 'name_of_nonce_field'); ?>

        <div class="panel">
            <div class="panel-heading" style="font-size: 25px;text-align: center;padding-bottom: 3%;padding-top: 2%">
                <?php _e( 'Settings','MBWPL' ); ?>
            </div>

            <table class="table">
                <tbody>
                <tr class="form_header_xtz">
                    <td>
                        <?php _e( 'Messenger','MBWPL' ); ?>
                    </td>
                    <td>
                        <?php _e( 'Login or phone number','MBWPL' ); ?>
                    </td>
                    <td>
                        <?php _e( 'Onclick event','MBWPL' ); ?>
                    </td>

                    <td>
                        <?php _e( 'Status','MBWPL' ); ?>
                    </td>
                </tr>

                <?php foreach ($arrresult as $val) { ?>

                    <tr>
                        <input type="hidden" name="socials[<?= mb_strtolower($val->title); ?>][id]"
                               value="<?= $val->id; ?>">

                        <input type="hidden" name="socials[<?= mb_strtolower($val->title); ?>][code]"
                               value="<?= $val->code; ?>">

                        <td><input type="text" name="socials[<?= mb_strtolower($val->title); ?>][title]" readonly
                                   value="<?= $val->title; ?>"></td>

                        <td><input id="validate_<?= mb_strtolower($val->title); ?>" type="text"
                                   placeholder="<?= $val->placeholder; ?>"
                                   name="socials[<?= mb_strtolower($val->title); ?>][href]"
                                   value="<?= $val->href; ?>"></td>

                        <td><input type="text" name="socials[<?= mb_strtolower($val->title); ?>][onclick]"
                                   value="<?= $val->onclick; ?>"></td>

                        <?php (int)$val->active == 1 ? $check = "checked" : $check = ''; ?>

                        <td style="text-align: center;">
                            <input type="hidden" id="socials[<?= mb_strtolower($val->title); ?>][active]"
                                   name="socials[<?= mb_strtolower($val->title); ?>][active]"
                                   value="<?= $val->active; ?>">

                            <input type="checkbox" data-name="socials[<?= mb_strtolower($val->title); ?>][active]"
                                   name="socials[<?= mb_strtolower($val->title); ?>][active]"
                                   value="<?= $val->active ?>" <?= $check; ?>>
                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>
            <br><br>

            <?php $select_val = [
                'right_center' => 'Right center',
            ];
            ?>

            <div class="form-group" style="display: none;opacity: 0;position: absolute;">
                <label class="control-label col-lg-3"><?php _e( 'Position','MDWPL' ); ?></label>
                <div class="col-lg-4">

                    <select name="params[position]" class="form-control" id="input-position">

                        <?php
                        $params = unserialize($res_params[0]->params);
                        $data = [];

                        foreach ($params as $key => $v) {
                            $data[$key] = $v;
                        }
                        ?>

                        <?php foreach ($select_val as $k => $value) { ?>
                            <option value="<?= $k ?>" <?php if ($k == $data['position']) : ?> selected="selected" <?php endif; ?> ><?= $value ?></option>
                        <? } ?>

                    </select>
                </div>
            </div>


            <table id="module_style" class="table">
                <thead>
                <tr>

                    <td class="text-left" style="font-size: 20px;padding-bottom: 1%"><?php _e( 'Set of icons','MBWPL' ); ?></td>
                </tr>
                </thead>
                <tbody>

                <td class="text-left style_1">
                    <!-- / Share buttons - Кнопки социальных сетей -->
                    <div class="share-buttons-list">

                        <div class="share-buttons-item">
                            <img src="<?= WPMB_IMAGE ?>viber.png">
                        </div>


                        <div class="share-buttons-item">
                            <img src="<?= WPMB_IMAGE ?>whatsapp.png">
                        </div>

                    </div>
                </td>

                </tbody>
            </table>
            <p class="center"><input type="submit" name="submitUpdate" value=" <?php _e( 'Save','MBWPL' ); ?>" class="btn btn-default"></p>
        </div>
    </form>
</div>

