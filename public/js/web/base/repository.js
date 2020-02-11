var web_base_repository = {
    clearStrToSearch: function(str) {
        str = str.replace(/[,]+/g,'.');
        str = str.replace(/[.]+/g,'.');
        str = str.replace(/[-]+/g,'-');
        str = str.replace(/[+/\\*!@?]/g,' ');

        str = str.replace(/[^[.-]0-9a-zа-яіїЁё]/gim,' ');
        str = str.trim();

        str = str.replace(/\s[.]/g,' ');
        str = str.replace(/\s[-]/g,' ');

        str = str.replace(/[.]\s/g,' ');
        str = str.replace(/[-]\s/g,' ');

        while(['.', '-'].indexOf(str.charAt(0)) !== -1 ){
            str = str.substr(1);
        }

        str = str.trim();
        str = str.replace(/\s+/g,'+');

        return str;
    }
};








