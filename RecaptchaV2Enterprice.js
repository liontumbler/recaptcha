/**
 * Autor: edwin velasquez jimenez;
 * facil implementacion recaptchaV2 enterprice
*/

class RecaptchaV2Enterprice {
    _keyPublic;
    constructor(element = Element, keyPublic = String, methodInvisible = false) {
        this._keyPublic = keyPublic;

        const div = document.createElement('div');
        div.className = 'g-recaptcha';
        div.setAttribute('data-sitekey', this._keyPublic);
        if (methodInvisible) {
            div.setAttribute('data-size', 'invisible');
            div.setAttribute('data-callback', methodInvisible);
        }
        
        const script = document.createElement('script');
        script.src = 'https://www.google.com/recaptcha/enterprise.js';
        script.async = true;
        script.defer = true;

        element.append(div);
        element.append(script);
    }

    validarRV3SNormal(fn, rutaServidor = 'scaptcha.php', accion = 'login') {
        try {
            const token = grecaptcha.enterprise.getResponse();
            if(!token){
                fn(false);
            }else{
                this._consumirServicio(token, accion, rutaServidor, (res) => {
                    fn(res);
                });
            }
        } catch (error) {
            console.log('error', error);
            fn(error);
        }
    }
    
    validarRV3SInvisible(token, fn, rutaServidor = 'scaptcha.php', accion = 'login') {
        this._consumirServicio(token, accion, rutaServidor, (res) => {
            fn(res);
        });
    }

    _consumirServicio(token, accion, rutaServidor, fn) {
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
                fn(_validarResRecaptcha(data));
            }else{
                console.error('errorRecaptcha', 'servidor google no response');
                fn(false);
            }
        }).catch(error => {
            console.error('errorRecaptcha', error);
            fn(false);
        });
    }

    _validarResRecaptcha(res) {
        //return false;
        //console.log(res);
        let validador = false;
        if (res.riskAnalysis && res.riskAnalysis.score >= 0.5)
            validador = true;

        return validador;
    }
}
