var viewPresenter = {
    findElement : function (e, element) {
        if(e){
            e = e.split(',');
            $.each(e, function (i, v) {
                if(i !== e.length-1 || v !== '') {
                    if(v === ''){
                        element = element.parent();
                    }else if(v !== ''){
                        element = element.find(v);
                    }
                }
            });
        }
        return element;
    },

    overflow: {
        showAnime: function (_this, e, hideSelf) {
            e = viewPresenter.findElement(e, $(_this));

            e.animate({maxHeight: 1000}, 500, function () {
                e.css({maxHeight: '100%'});
            });
            if(hideSelf){
                setTimeout(function () {
                    viewPresenter.hide(_this);
                }, 200);
            }
        },

        visible: function (_this, e) {
            viewPresenter.findElement(e, $(_this)).css({'overflow': 'auto', 'height': 'auto'});
        }
    },

    show: function (_this, e) {
        this.findElement(e, $(_this)).show();
    },

    hide: function (_this, e) {
        this.findElement(e, $(_this)).hide();
    },

    insertInputVal: function (_this, e, text) {
        this.findElement(e, $(_this)).val(text);
    },
};
