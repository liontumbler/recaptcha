/**
 * Autor: edwin velasquez jimenez;
 * facil implementacion recaptchaV3 community
*/

class RecaptchaV3Community {
    _keyPublic;
    constructor(element = Element, keyPublic = String) {
        this._keyPublic = keyPublic;
        const script = document.createElement('script');
        script.src = 'https://www.google.com/recaptcha/api.js?render=' + this._keyPublic;

        element.append(script);
    }

    validarRV3S(fn, rutaServidor = 'scaptcha.php', accion = 'login') {
        try {
            grecaptcha.ready(async () => {
                const token = await grecaptcha.execute(this._keyPublic, {
                    action: accion
                });
    
                //console.log(token);
                const datos = new FormData();
                datos.append('response', token);
                datos.append('accion', accion);
    
                fetch(rutaServidor, {
                    method: 'POST',
                    body: datos,
                }).then(data => {
                    //console.log('then1', data);
                    if(!data.ok)
                        return data.ok;
    
                    return data.json();
                }).then(data => {
                    //console.log(data, 'dataASD');
                    if(data){
                        fn(this._validarResRecaptcha(data));
                    }else{
                        console.error('errorRecaptcha', 'servidor google no response');
                        fn(false);
                    }
                }).catch(error => {
                    console.error('errorRecaptcha', error);
                    fn(false);
                });
            });
        } catch (error) {
            console.log('error', error);
            fn(error);
        }
    }

    _validarResRecaptcha(res) {
        //return false;
        let validador = false;
        //console.log(res);
        if (res.score >= 0.1 && res.success)
            validador = true;

        return validador;
    }
}
