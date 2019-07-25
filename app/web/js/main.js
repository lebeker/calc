'use strict';

import {CalcAPI} from './api.js';

const api = new CalcAPI();
const input = document.getElementById('calc-input');
const err = document.getElementById('error');
const hideErr = () => err.style.display = 'none';

err.addEventListener('click', hideErr);
document.getElementById('backspace').addEventListener('click', (e) => input.value = input.value.slice(0, -1));
document.getElementById('clear').addEventListener('click', (e) => input.value = "");
document.getElementById('calcBtn').addEventListener('click', (e) =>
    api._request(input.value, (() => {
        const names = [...document.querySelectorAll('.variables input.var-name')].map(el => el.value);
        const values = [...document.querySelectorAll('.variables input.var-val')].map(el => el.value);
        return names.reduce((a , n, i) => Object.assign(a, {[n]: values[i]}), {});
    })())
        .then(async (res) => {
            if (res.error) throw new Error(res.error);
            hideErr();
            const resEl = document.getElementById('result');
            resEl.innerHTML =`<h5>${res.result}</h5>`;
            let i = 0;

            for (const t of res.trace.filter(t => '#' === t.var[0])) {
                resEl.innerHTML+= `<div class="log">${t.var}: ${t.equation} = ${t.res}</div>`;
                await new Promise((resolve) => setTimeout(resolve,500));
            }
            resEl.innerHTML+= `<br /><div>${res.result}</div>`;
        })
        .catch(e => {
            err.innerHTML =`<h5>${e.message}</h5>`;
            err.style.display = 'block';
        })
);

document.getElementById('add-variable').addEventListener('click', (e) => {
    document.querySelector('.variables').appendChild(
        document.querySelector('.variables .collection-item:last-child').cloneNode(true)
    );
    e.stopPropagation();
});

[...document.querySelectorAll('.calculator .digits, .calculator .operations .amber')]
    .map(btn => btn.addEventListener('click', (e) => input.value += e.target.innerHTML));