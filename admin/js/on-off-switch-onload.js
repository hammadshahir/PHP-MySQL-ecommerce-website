
if (!DG)var DG = {};

DG.OnOffSwitchAuto = function (config) {

    var properties = DG.OnOffSwitchProperties;

    $( document ).ready(function() {
        if(config.cls){
            var els = $(config.cls);
            var index = 0;
            for(var i=0,len=els.length;i<len;i++){
                var elementConfig = jQuery.extend({}, config);
                var el = $(els[i]);
                if(!els[i].id){
                    els[i].id = "dg-switch-" + index;
                    index++;
                }
                elementConfig.el = "#" + els[i].id

                for(var j=0;j<properties.length;j++){
                    var attr = "data-"+ properties[j];
                    var val = el.attr(attr);
                    if(val){
                        elementConfig[properties[j]] = val;
                    }
                }

                new DG.OnOffSwitch(
                    elementConfig
                );
            }
        }
    });


};

