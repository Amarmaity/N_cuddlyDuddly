(function () {
    'use strict';

    // Set to true to enable console debug logs while testing
    const PHONE_DEBUG = false;

    function debug(...args) {
        if (PHONE_DEBUG) console.log('[phone-number]', ...args);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const countryCodeElem = document.getElementById('country-code');
        const flagImg = document.getElementById('flag-img');
        const phone = document.querySelector('[name="phone"]');

        function setCountry(callingCode, countryIso) {
            if (callingCode && countryCodeElem) countryCodeElem.innerText = '+' + callingCode;
            if (countryIso && flagImg) {
                flagImg.src = `https://flagcdn.com/w40/${countryIso.toLowerCase()}.png`;
                flagImg.style.display = 'inline';
            }
        }

        // 1) initial detection by IP (best-effort)
        fetch('https://ipwho.is/')
            .then(res => res.json())
            .then(data => {
                if (!data || !data.success) return;
                debug('ipwho.is ->', data);
                setCountry(data.calling_code, data.country_code);
            })
            .catch(err => {
                debug('ipwho.is failed', err);
                setCountry('91', 'IN'); // fallback
            });

        // 2) Local calling code map and detection
        const MAP = {
            '1': 'US', '7': 'RU', '20': 'EG', '27': 'ZA', '30': 'GR', '31': 'NL', '32': 'BE',
            '33': 'FR', '34': 'ES', '36': 'HU', '39': 'IT', '40': 'RO', '41':'CH', '44': 'GB',
            '49': 'DE', '52': 'MX', '55': 'BR', '61': 'AU', '62':'ID', '63':'PH','64':'NZ',
            '65':'SG', '66':'TH', '81':'JP','82':'KR','84':'VN','86':'CN','90':'TR','91':'IN',
            '92':'PK','93':'AF','94':'LK','95':'MM','98':'IR','211':'SS','213':'DZ','254':'KE',
            '255':'TZ','256':'UG','971':'AE','880':'BD'
        };

        function matchPrefix(str) {
            let s = (str || '').replace(/\D/g, '');
            for (let len = 3; len >= 1; len--) {
                let code = s.slice(0, len);
                if (!code) continue;
                if (MAP[code]) return { callingCode: code, countryIso: MAP[code] };
            }
            return null;
        }

        function simpleDetectFromNumber(val) {
            if (!val) return null;
            let digits = String(val).replace(/[^\d+]/g, '');
            if (digits.startsWith('00')) digits = '+' + digits.slice(2);

            if (digits.startsWith('+')) {
                let after = digits.slice(1);
                let res = matchPrefix(after);
                debug('detect (+) after ->', after, '=>', res);
                return res;
            }

            // no plus — try matching leading digits as calling code
            let raw = digits.replace(/\D/g, '');
            let res = matchPrefix(raw);
            if (res) {
                debug('detect (no +) raw ->', raw, '=>', res);
                return res;
            }

            // fallback heuristics (common case: local 10-digit numbers that may be US)
            if (raw.length === 10 && raw.startsWith('1')) return { callingCode: '1', countryIso: 'US' };

            debug('detect no match for ->', val);
            return null;
        }

        // Expose for testing in console
        window.simpleDetectFromNumber = simpleDetectFromNumber;

        // Debounced input handler
        let timer;
        function onPhoneInput(e) {
            clearTimeout(timer);
            timer = setTimeout(() => {
                const val = e.target.value;
                const detected = simpleDetectFromNumber(val);
                debug('onPhoneInput', val, detected);
                if (detected && detected.callingCode) {
                    setCountry(detected.callingCode, detected.countryIso);
                }
            }, 200);
        }

        if (phone) phone.addEventListener('input', onPhoneInput);
    });
})();
