(function(){
    define(['jquery', 'bootstrap'], function ($, bs) {

        var api = null;

        var _buildModalContainer = function(title, content, showClose){
            var $container,
                container =
                    '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> ' +
                    '    <div class="modal-dialog"> ' +
                    '    <div class="modal-content"> ' +
                    '        <div class="modal-header"> ' +
                    '            <h4 class="modal-title" id="myModalLabel">__title__</h4> ' +
                    '        </div> ' +
                    '        <div class="modal-body">__widget__</div> ' +
                    '        <div class="modal-footer"> ' +
                    '            <button type="button" class="btn btn-default close-button" data-dismiss="modal">Close</button> ' +
                    '        </div> ' +
                    '    </div> ' +
                    '    </div> ' +
                    '</div>'
            ;

            $container = $(container.replace('__widget__', content).replace('__title__', title));

            if(showClose === false){
                $container.find('button.close-button').hide();
            }

            return $container;
        };

        // convert a form to a multi dimentional array
        var _serializeForm = function($form){

            var self = this,
                json = {},
                push_counters = {},
                patterns = {
                    "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                    "key":      /[a-zA-Z0-9_]+|(?=\[\])/g,
                    "push":     /^$/,
                    "fixed":    /^\d+$/,
                    "named":    /^[a-zA-Z0-9_]+$/
                };

            this.build = function(base, key, value){
                base[key] = value;
                return base;
            };

            this.push_counter = function(key){
                if(push_counters[key] === undefined){
                    push_counters[key] = 0;
                }
                return push_counters[key]++;
            };

            $.each($form, function(i,v){

                // skip invalid keys
                if(!patterns.validate.test(this.name)){
                    return;
                }

                var k,
                    keys = i.match(patterns.key),
                    merge = v,
                    reverse_key = i;

                while((k = keys.pop()) !== undefined){

                    // adjust reverse_key
                    reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), '');

                    // push
                    if(k.match(patterns.push)){
                        merge = self.build([], self.push_counter(reverse_key), merge);
                    }

                    // fixed
                    else if(k.match(patterns.fixed)){
                        merge = self.build({}, k, merge);
                    }

                    // named
                    else if(k.match(patterns.named)){
                        merge = self.build({}, k, merge);
                    }
                }

                json = $.extend(true, json, merge);
            });

            return json;
        };

        var _call = function(url, options){

            if(options === undefined)
                options = {};

            var opts = $.extend(true, {}, options, { url: url });

            $.ajax(opts);
        };

        var _saveForm = function($form, callback_success, callback_failure){


            var $formModal = _buildModalContainer('Saving Form...', '<div class="modal-message">Please wait while we save your form.</div>', false);
            $formModal.modal();

            var returned = 0;

            var data, field, fname, method;

            method = $form[0].method;

            callback_success = callback_success || null;
            callback_failure = callback_failure || null;

            data = {};

            for(var i=0 ; i<$form[0].length ; ++i){
                field = $form[0][i];
                if(field.name){
                    fname = field.name;

                    if(field.name === '_method'){
                        method = field.value;
                    } else if(field.type === 'radio'){
                        data[fname] = data[fname] || [];
                        if(field.checked)
                            data[fname].push(field.value);
                    } else if(field.type === 'checkbox'){
                        data[fname] = field.checked ? field.value : null;
                    } else {
                        if(field.name.match(/\[\]$/)){
                            fname = field.name.replace(/\[\]$/, '');
                            data[fname] = data[fname] || [];
                            data[fname].push($(field).val());
                        } else {
                            data[fname] = $(field).val();
                        }
                    }
                }
            }

            var sData = _serializeForm(data);
            var buttons =  $form.find('button, input[type="submit"]');

            if(buttons)
                buttons.prop('disabled', true);

            _call($form[0].action, {
                data: JSON.stringify(sData),
                method: method,
                success: function(e,s,x){
                    if(buttons)
                        buttons.prop('disabled', false);
                    $formModal.find('.modal-message').html("The form has been saved.");
                    $formModal.find('.close-button').show();
                    callback_success.call(this, e,s,x);
                },
                error: function(e,b,c){
                    if(buttons)
                        buttons.prop('disabled', false);

                    var html = '<p>An error occured when saving the form.</p><div id="FormErrors" class="alert alert-danger">';
                    if(e.status === 400){
                        if(e.responseJSON){
                            var errors = _parseError(e.responseJSON.errors, null, true);
                            var str = '';
                            for(var i in errors){
                                if(errors[i].length){
                                    html += "<p class=''><strong style='text-transform:capitalize;'>"+i+":</strong> "+errors[i].join(', ')+"</p>";
                                }
                            }
                            $('#FormErrors').html(str).slideDown();
                        } else {
                            alert(status);
                        }
                    } else {
                        html += "<p><strong style='text-transform:capitalize;'>Oh Dear.</strong> Looks like we have a problem here, the server responded with a "+e.status+" resonse.</p></div>";
                    }
                    html += '</div>';

                    $formModal.find('.modal-message').html(html);
                    if('function' === typeof callback_failure){
                        callback_failure.call(this, e,b,c,$formModal);
                    }
                }
            });
        };

        var _parseError = function(e, p, flatten){
            if(flatten === undefined){
                flatten = false;
            }

            if(!p){
                p = 'error';
            }
            var errors = {}, childErrors;
            for(var i in e){
                if(i === 'errors'){
                    errors[p] = e[i];
                } else if (i !== 'children' && ("string" === typeof e[i] || e[i] instanceof Array)){
                    errors[i] = e[i];
                } else if(i === 'children' && e[i] instanceof Array && !flatten){
                    errors[p] = []
                    for(var j in e[i]){
                        errors[p].push(_parseError(e[i][j], p, flatten));
                    }
                } else {
                    childErrors = _parseError(e[i], i, flatten);
                    for(var j in childErrors){
                        errors[j] = childErrors[j];
                    }
                }
            }

            return errors;
        };

        var apiRoutes = {};
        var _addApiRoute = function(key, route){
            apiRoutes[key] = route;
        };
        var _getApiRoute = function(key){
            return apiRoutes[key];
        };

        var _poke = function(){
            if("undefined" != typeof window.lineStormTags && 'session' in window.lineStormTags){
                var now = new Date().getTime();
                api.call(window.lineStormTags.session.poke, {
                    data: {
                        t: now
                    },
                    success: function(o,state,xhr){
                        if(xhr.status === 204){
                            return;
                        }

                        var $formModal = _buildModalContainer( 'Session Error', '<div class="alert-error"><p>The session entered an unknown state ('+xhr.status+')</p></div>');
                        $formModal.modal();

                    },
                    error: function(xhr, state, o){
                        var $formModal;

                        if(xhr.status === 403){

                            $formModal = _buildModalContainer( 'Session Error', '<div class="alert-error"><p>Your session has expired</p></div>', false);
                            $formModal.find('.modal-footer').append('<a href="'+xhr.responseJSON.url+'" class="btn btn-primary">Login</a>');
                            $formModal.modal();
                            clearInterval(_sessionPokeInterval);
                            return;
                        }

                        $formModal = _buildModalContainer( 'Session Error', '<div class="alert-error"><p>The session entered an unknown state ('+xhr.status+')</p></div>');
                        $formModal.modal();
                    }
                });
            } else {
                clearInterval(_sessionPokeInterval);
            }
        };

        api = {
            serializeForm:  _serializeForm,
            saveForm:       _saveForm,
            call:           _call,
            parseError:     _parseError,
            addApiRoute:    _addApiRoute,
            getApiRoute:    _getApiRoute,
            sessionPoke:    _poke
        };

        // keep our API session alive
        var _sessionPokeInterval = setInterval(_poke, 600 * 1000);

        return api;
    });
})();
