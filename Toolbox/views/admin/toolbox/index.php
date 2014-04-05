<div id="maincolumn">

    <h2 class="main module-toolbox"><?php echo lang('module_toolbox_title'); ?></h2>

    <div class="main subtitle">
        <p class="lite">
            <?php echo lang('module_toolbox_about'); ?>
        </p>
    </div>
    <hr />

    <!-- Toolbox Tabs -->
    <div id="toolboxTab" class="mainTabs">
        <ul class="tab-menu">
            <li><a><?php echo lang('module_toolbox_title_minify'); ?></a></li>
            <li><a><?php echo lang('module_toolbox_title_qrcode'); ?></a></li>
            <li><a><?php echo lang('module_toolbox_title_recaptcha'); ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>
    <div id="toolboxTabContent">

        <!-- Minify Settings -->
        <div class="tabcontent">

            <form name="minifyForm" id="minifyForm" method="post">

                <input type="hidden" name="form" value="minify" />

                <!-- minify_development -->
                <dl class="mb10">
                    <dt>
                        <label for="minify_development" title="<?php echo lang('module_toolbox_label_minify_development_help'); ?>"><?php echo lang('module_toolbox_label_minify_development'); ?></label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="minify_development" class="inputcheckbox" id="minify_development" <?php if ($toolbox['minify_development'] == '1'):?>checked="checked"<?php endif;?> value="1" />
                    </dd>
                </dl>

                <!-- minify_local_compiler -->
                <dl class="mb10">
                    <dt>
                        <label for="minify_local_compiler" title="<?php echo lang('module_toolbox_label_minify_local_compiler_help'); ?>"><?php echo lang('module_toolbox_label_minify_local_compiler'); ?></label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="minify_local_compiler" class="inputcheckbox" id="minify_local_compiler" <?php if ($toolbox['minify_local_compiler'] == '1'):?>checked="checked"<?php endif;?> value="1" />
                    </dd>
                </dl>

                <!-- minify_compress -->
                <dl class="mb10">
                    <dt>
                        <label for="minify_compress" title="<?php echo lang('module_toolbox_label_minify_compress_help'); ?>"><?php echo lang('module_toolbox_label_minify_compress'); ?></label>
                    </dt>
                    <dd>
                        <input type="checkbox" name="minify_compress" class="inputcheckbox" id="minify_compress" <?php if ($toolbox['minify_compress'] == '1'):?>checked="checked"<?php endif;?> value="1" />
                    </dd>
                </dl>

                <!-- minify_build_dir -->
                <dl class="mb10">
                    <dt>
                        <label for="minify_build_dir" title="<?php echo lang('module_toolbox_label_minify_build_dir_help'); ?>"><?php echo lang('module_toolbox_label_minify_build_dir'); ?></label>
                    </dt>
                    <dd>
                        <input id="minify_build_dir" name="minify_build_dir" type="text" class="inputtext w300" value="<?php echo $toolbox['minify_build_dir']; ?>" />
                    </dd>
                </dl>

                <!-- minify_assets_dir -->
                <dl class="mb10">
                    <dt>
                        <label for="minify_assets_dir" title="<?php echo lang('module_toolbox_label_minify_assets_dir_help'); ?>"><?php echo lang('module_toolbox_label_minify_assets_dir'); ?></label>
                    </dt>
                    <dd>
                        <input id="minify_assets_dir" name="minify_assets_dir" type="text" class="inputtext w300" value="<?php echo $toolbox['minify_assets_dir']; ?>" />
                    </dd>
                </dl>

                <!-- minify_css_dir -->
                <dl class="mb10">
                    <dt>
                        <label for="minify_css_dir" title="<?php echo lang('module_toolbox_label_minify_css_dir_help'); ?>"><?php echo lang('module_toolbox_label_minify_css_dir'); ?></label>
                    </dt>
                    <dd>
                        <input id="minify_css_dir" name="minify_css_dir" type="text" class="inputtext w300" value="<?php echo $toolbox['minify_css_dir']; ?>" />
                    </dd>
                </dl>

                <!-- minify_js_dir -->
                <dl class="mb10">
                    <dt>
                        <label for="minify_js_dir" title="<?php echo lang('module_toolbox_label_minify_js_dir_help'); ?>"><?php echo lang('module_toolbox_label_minify_js_dir'); ?></label>
                    </dt>
                    <dd>
                        <input id="minify_js_dir" name="minify_js_dir" type="text" class="inputtext w300" value="<?php echo $toolbox['minify_js_dir']; ?>" />
                    </dd>
                </dl>

                <dl class="mb10">
                    <dt>&nbsp;</dt>
                    <dd>
                        <input id="minifySubmit" type="submit" class="submit" value="<?php echo lang('ionize_button_save'); ?>" />
                    </dd>
                </dl>

            </form>

        </div>

        <!-- QR Code Settings -->
        <div class="tabcontent">

            <form name="qrcodeForm" id="qrcodeForm" method="post">

                <input type="hidden" name="form" value="qrcode" />

                <!-- qr_cacheable -->
                <dl class="mb10">
                    <dt>
                        <label for="qr_cacheable"><?php echo lang('module_toolbox_label_qr_cacheable'); ?></label>
                    </dt>
                    <dd>
                        <input class="inputcheckbox" <?php if ($toolbox['qr_cacheable'] == '1'):?>checked="checked"<?php endif;?> type="checkbox" name="qr_cacheable" id="qr_cacheable" value="1" />
                    </dd>
                </dl>

                <!-- qr_cachedir -->
                <dl class="mb10">
                    <dt>
                        <label for="qr_cachedir" title="<?php echo lang('module_toolbox_label_qr_cachedir_help'); ?>"><?php echo lang('module_toolbox_label_qr_cachedir'); ?></label>
                    </dt>
                    <dd>
                        <input id="qr_cachedir" name="qr_cachedir" type="text" class="inputtext w300" value="<?php echo $toolbox['qr_cachedir']; ?>" />
                    </dd>
                </dl>

                <!-- qr_errorlog -->
                <dl class="mb10">
                    <dt>
                        <label for="qr_errorlog" title="<?php echo lang('module_toolbox_label_qr_errorlog_help'); ?>"><?php echo lang('module_toolbox_label_qr_errorlog'); ?></label>
                    </dt>
                    <dd>
                        <input id="qr_errorlog" name="qr_errorlog" type="text" class="inputtext w300" value="<?php echo $toolbox['qr_errorlog']; ?>" />
                    </dd>
                </dl>

                <!-- qr_quality -->
                <dl class="mb10">
                    <dt>
                        <label for="qr_quality"><?php echo lang('module_toolbox_label_qr_quality'); ?></label>
                    </dt>
                    <dd>
                        <input class="inputcheckbox" <?php if ($toolbox['qr_quality'] == '1'):?>checked="checked"<?php endif;?> type="checkbox" name="qr_quality" id="qr_quality" value="1" />
                    </dd>
                </dl>

                <!-- qr_size -->
                <dl class="mb10">
                    <dt>
                        <label for="qr_size" title="<?php echo lang('module_toolbox_label_qr_size_help'); ?>"><?php echo lang('module_toolbox_label_qr_size'); ?></label>
                    </dt>
                    <dd>
                        <input id="qr_size" name="qr_size" type="text" class="inputtext w300" value="<?php echo $toolbox['qr_size']; ?>" />
                    </dd>
                </dl>

                <!-- qr_black -->
                <dl class="mb10">
                    <dt>
                        <label for="qr_black" title="<?php echo lang('module_toolbox_label_qr_black_help'); ?>"><?php echo lang('module_toolbox_label_qr_black'); ?></label>
                    </dt>
                    <dd>
                        <input id="qr_black" name="qr_black" type="text" class="inputtext w300" value="<?php echo $toolbox['qr_black']; ?>" />
                    </dd>
                </dl>

                <!-- qr_white -->
                <dl class="mb10">
                    <dt>
                        <label for="qr_white" title="<?php echo lang('module_toolbox_label_qr_white_help'); ?>"><?php echo lang('module_toolbox_label_qr_white'); ?></label>
                    </dt>
                    <dd>
                        <input id="qr_white" name="qr_white" type="text" class="inputtext w300" value="<?php echo $toolbox['qr_white']; ?>" />
                    </dd>
                </dl>

                <dl class="mb10">
                    <dt>&nbsp;</dt>
                    <dd>
                        <input id="qrcodeSubmit" type="submit" class="submit" value="<?php echo lang('ionize_button_save'); ?>" />
                    </dd>
                </dl>

            </form>

        </div>

        <!-- reCAPTCHA Settings -->
        <div class="tabcontent">

            <form name="recaptchaForm" id="recaptchaForm" method="post">

                <input type="hidden" name="form" value="recaptcha" />

                <!-- public_key -->
                <dl class="mb10">
                    <dt>
                        <label for="recaptcha_public_key"><?php echo lang('module_toolbox_label_recaptcha_public_key'); ?></label>
                    </dt>
                    <dd>
                        <input id="recaptcha_public_key" name="recaptcha_public_key" type="text" class="inputtext w300" value="<?php echo $toolbox['recaptcha_public_key']; ?>"; />
                    </dd>
                </dl>

                <!-- private_key -->
                <dl class="mb10">
                    <dt>
                        <label for="recaptcha_private_key"><?php echo lang('module_toolbox_label_recaptcha_private_key'); ?></label>
                    </dt>
                    <dd>
                        <input id="recaptcha_private_key" name="recaptcha_private_key" type="text" class="inputtext w300" value="<?php echo $toolbox['recaptcha_private_key']; ?>" />
                    </dd>
                </dl>

                <!-- Encryption key -->
                <dl class="mb10">
                    <dt>
                        <label for="recaptcha_theme"><?php echo lang('module_toolbox_label_recaptcha_theme'); ?></label>
                    </dt>
                    <dd>
                        <select id="recaptcha_theme" name="recaptcha_theme" class="select">
                            <option value="red"<?php echo (($toolbox['recaptcha_theme'] == 'red') ? ' selected="selected"' : ''); ?>><?php echo lang('module_toolbox_label_recaptcha_theme_red'); ?></option>
                            <option value="white"<?php echo (($toolbox['recaptcha_theme'] == 'white') ? ' selected="selected"' : ''); ?>><?php echo lang('module_toolbox_label_recaptcha_theme_white'); ?></option>
                            <option value="blackglass"<?php echo (($toolbox['recaptcha_theme'] == 'blackglass') ? ' selected="selected"' : ''); ?>><?php echo lang('module_toolbox_label_recaptcha_theme_blackglass'); ?></option>
                            <option value="clean"<?php echo (($toolbox['recaptcha_theme'] == 'clean') ? ' selected="selected"' : ''); ?>><?php echo lang('module_toolbox_label_recaptcha_theme_clean'); ?></option>
                        </select>
                    </dd>
                </dl>

                <dl class="mb10">
                    <dt>&nbsp;</dt>
                    <dd>
                        <input id="recaptchaFormSubmit" type="submit" class="submit" value="<?php echo lang('ionize_button_save'); ?>" />
                    </dd>
                </dl>

            </form>

        </div>

    </div>

</div>
<script type="text/javascript">

    var module_url = admin_url + 'module/toolbox/toolbox/';

    // Get Empty Toolbox
    ION.initToolbox('empty_toolbox');

    // Form Submits
    ION.setFormSubmit('minifyForm', 'minifySubmit', module_url + 'save');
    ION.setFormSubmit('qrcodeForm', 'qrcodeSubmit', module_url + 'save');
    ION.setFormSubmit('recaptchaForm', 'recaptchaFormSubmit', module_url + 'save');

    // Toolbox Tabs
    new TabSwapper({
        tabsContainer: 'toolboxTab',
        sectionsContainer: 'toolboxTabContent',
        selectedClass: 'selected',
        deselectedClass: '',
        tabs: 'li',
        clickers: 'li a',
        sections: 'div.tabcontent',
        cookieName: 'toolboxTab'
    });

</script>