document.observe('dom:loaded', function() {
    var content_table = $$('#page_cmstemplate_content_fieldset table tbody')[0],
        ids = [],
        no_fields_row = content_table.down('tr'),
        data = $('page_loaded_data').value.evalJSON(true);

    analyseText($('page_template').value);

    window.CmsTemplate = (function() {
        return {
            updateCmsTemplateFields: function() {
                updateData();
                removeAllFields();
                analyseText($('page_template').value);
            }
        }
    }());

    function updateData() {
        ids.each(function(id) {
            data[id] = $('cmstemplate_'+id).value;
        });
    }

    function getData(id) {
        if (data[id]) {
            return data[id];
        }
        return '';
    }

    function analyseText(text) {
        ids = [];
        var pattern = /\{\{([\w\s:]+)\}\}/gi;
        while (result = pattern.exec(text)) {
            result = result[1].split(':');
            var label = result[0],
                type = result.length > 1 ? result[1] : null;
            addField(type, label);
        }
    }

    function addField(type, label) {
        var id = generateId(label),
            input = '',
            value = getData(id);
        ids.push(id);

        switch(type) {
            case 'textarea':
                input = '<textarea id="cmstemplate_'+id+'" name="cmstemplate_'+id+'" title="'+label+'" rows="2" cols="15" type="text" class="textarea">'+value+'</textarea>';
                break;
            default:
                input = '<input id="cmstemplate_'+id+'" name="cmstemplate_'+id+'" value="'+value+'" title="'+label+'" type="text" class="input-text">';
                break;
        }

        content_table.insert('<tr class="cmstemplate-dynamic-row">'+
                        '<td class="label"><label for="cmstemplate_'+id+'">'+label+'</label></td>'+
                        '<td class="value">'+
                        input+
                        '</td>'+
                    '</tr>');
        no_fields_row.hide();
    }

    function removeAllFields() {
        $$('.cmstemplate-dynamic-row').each(function(row) {
            row.remove();
        });
        no_fields_row.show();
    }

    function generateId(label) {
        var id = label.toLowerCase().replace(/[^A-Za-z0-9]/g, '_');
        if (!id) id = 'input';
        var original_id = id;
        for (var i = 1; i; i++) {
            if (!idExists(id)) break;
            id = original_id + '_' + i;
        }
        return id;
    }

    function idExists(id) {
        for (var i = 0; i < ids.length; i++) {
            if (ids[i] === id) {
                return true;
            }
        }
        return false;
    }
});