<div id="bulk_attributes_block" class="panel woocommerce_options_panel">
<script>
(function($){

$("document").ready(function(){

    $("select.dropdown").dropdown();

    $('#attribute-submit').click(function(e){
        e.preventDefault();

        var data = {
            
			'post_id': <?php echo intval( $product->get_id() ); ?>,
			'product_type': '<?php echo esc_js( $product->get_type() ); ?>',
			'action': 'woocommerce_save_attributes',
			'security': '<?php echo esc_attr( wp_create_nonce( 'save-attributes' ) ); ?>'
        };

        data['data'] = {};
        data['data']['attribute_names'] = {};
        data['data']['attribute_values'] = {};
        data['data']['attribute_visibility'] = {};
        data['data']['attribute_variation'] = {};
        data['data']['attribute_position'] = {};

        var co = 0;

        /* ALWAYS collect current custom attributes from WooCommerce attribute form fields */
        $('[name^="attribute_names["]').each(function(index){
            var name = $(this).val();
            if(name && name.indexOf('pa_') === -1){
                var val = $('[name="attribute_values['+index+']"]').val() || '';
                var vis = $('[name="attribute_visibility['+index+']"]').prop('checked') ? 1 : 0;
                var varr= $('[name="attribute_variation['+index+']"]').prop('checked') ? 1 : 0;

                data['data']['attribute_names'][co]      = name;
                data['data']['attribute_values'][co]    = val;
                data['data']['attribute_visibility'][co]= vis;
                data['data']['attribute_variation'][co] = varr;
                data['data']['attribute_position'][co]  = co;
                co++;
            }
        });

        /* taxonomy attributes from your plugin UI */
        <?php foreach ($attributes as $a) : ?>
        var select = $('#attr-dropdown-<?php echo intval( $a->attribute_id ); ?>');
        var values = select.parent().dropdown('get value');

        if(values && values.length){
            var list = values.map(function(v){
                return $("#attr-dropdown-<?php echo intval( $a->attribute_id ); ?> option[value='"+v+"']").text();
        });

            data['data']['attribute_names'][co]      = "pa_<?php echo esc_js( $a->attribute_name ); ?>";
            data['data']['attribute_values'][co]    = list.join(',');
            data['data']['attribute_visibility'][co]= 1;
            data['data']['attribute_variation'][co] = 0;
            data['data']['attribute_position'][co]  = co;
            co++;
        }
        <?php endforeach; ?>

        var url = "<?php echo esc_url( admin_url('admin-ajax.php') ); ?>";

        data['data'] = $.param(data['data']);

        $.ajax({
            url: url,
            type: 'post',
            data: $.param(data),
            beforeSend:function(){
                $('#attribute-submit').addClass('loading');
            },
            complete:function(){
                $('#attribute-submit').removeClass('loading');
                location.reload();
            }
        });
    });
    
    <?php foreach ($attributes as $a) : ?>
    $("#attr-dropdown-<?php echo intval( $a->attribute_id ); ?>").dropdown('set selected', [
        <?php
        $selected_items = get_the_terms( intval( $product->get_id() ), 'pa_' . $a->attribute_name );
        if ( ! empty( $selected_items ) && ! is_wp_error( $selected_items ) ) {
            $flag = false;
            foreach ( $selected_items as $term ) {
                if ( $flag ) {
                echo ', ';
                }
                echo "'" . esc_js( $term->term_id ) . "'";
                $flag = true;
            }
        }
        ?>
    ]);

    <?php endforeach ?>

});

})(jQuery3_1_1);
</script>


<div class="ui form" style="margin:1em;">
<?php foreach ($attributes as $a) : ?>
    <div class="field">
        <label><?php echo esc_html( $a->attribute_label ); ?></label>
        <select class="ui search dropdown attribute" multiple=""
        id="<?php echo esc_attr( 'attr-dropdown-' . intval( $a->attribute_id ) ); ?>">
        <?php
            $choices = get_terms([
                'taxonomy' => "pa_".$a->attribute_name,
                'hide_empty' => false
            ]);
        ?>
        <?php foreach ($choices as $choice) : ?>
            <option value="<?php echo esc_attr( $choice->term_id ); ?>">
                 <?php echo esc_html( $choice->name ); ?>
            </option>

        <?php endforeach ?>
        </select>
    </div>
<?php endforeach ?>
<button id="attribute-submit" class="ui button" type="button">ذخیره ویژگی‌ها</button>
</div>

</div>