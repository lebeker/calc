<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link rel="stylesheet" href="/css/style.css">
        <script src="/js/main.js" type="module"></script>
    </head>
    <body>
        <h1>Calc +</h1>
        <div class="container">
            <div class="row">
                <div class="col s3"><h4>Variables</h4></div>
                <div class="col s6"></div>
                <div class="col s3"><h4>Result</h4></div>
            </div>
            <div class="row">
                <div class="col s3">

                    <ul class="collection variables">
                        <li class="collection-item"><input class="var-name" value="A" /> = <input class="var-val" value="234" /></li>
                        <li class="collection-item"><input class="var-name" value="Bob" /> = <input class="var-val" value="2.34" /></li>
                        <li class="collection-item"><input class="var-name" value="a" /> = <input class="var-val" value="-2.34" /></li>
                    </ul>
                    <button id="add-variable" class="btn add">+</button>
                </div>
                <div class="col s6">
                    <div class="calculator card">
                        <div class="input"><input id="calc-input" /></div>
                        <div class="digits">
                            <div class="btn grey lighten-1">7</div><div class="btn grey lighten-1">8</div><div class="btn grey lighten-1">9</div>
                            <div class="btn grey lighten-1">4</div><div class="btn grey lighten-1">5</div><div class="btn grey lighten-1">6</div>
                            <div class="btn grey lighten-1">1</div><div class="btn grey lighten-1">2</div><div class="btn grey lighten-1">3</div>
                            <div class="btn grey lighten-1">0</div><div class="btn grey">.</div><div class="btn white"></div>
                        </div>
                        <div class="operations">
                            <div class="btn red lighten-3 backspace"><-</div><div class="btn red darken-4 clear"><b>C</b></div>
                            <div class="btn amber">(</div><div class="btn amber">)</div>
                            <div class="btn amber">+</div><div class="btn amber">-</div>
                            <div class="btn amber">*</div><div class="btn amber">/</div>
                        </div>
                        <button id="calcBtn" class="btn orange eq"> = </button>
                    </div>
                    <div id="error" class="card red lighten-3" style="display: none"></div>
                </div>
                <div id="result" class="col s3"></div>
            </div>
        </div>
        <script type="module">
            import {CalcAPI} from '/js/main.js';
            const api = new CalcAPI();
            const input = document.getElementById('calc-input');
            const err = document.getElementById('error');
            const hideErr = () => err.style.display = 'none';

            err.addEventListener('click', hideErr);
            document.getElementById('calcBtn').addEventListener('click', (e) =>
                api._request(input.value, (() => {
                    const names = [...document.querySelectorAll('.variables input.var-name')].map(el => el.value);
                    const values = [...document.querySelectorAll('.variables input.var-val')].map(el => el.value);
                    return names.reduce((a , n, i) => Object.assign(a, {[n]: values[i]}), {});
                })())
                .then(res => {
                    if (res.error) throw new Error(res.error);
                    hideErr();
                    const resEl = document.getElementById('result');
                    resEl.innerHTML =`<h5>${res.result}</h5>`;
                    let eq = input.value, i = 0;
                    Promise.all(res.trace.map((t) =>
                        new Promise((resolve) =>
                            eq.search(t.equation) == -1
                                ? resolve()
                                : setTimeout(() => {
                                    eq = eq.replace(t.equation, t.var);
                                    resEl.innerHTML+= `<div>${eq}</div>`;
                                }, (++i)*100)
                            ))
                    )
                    .then(() => resEl.innerHTML+= `<div>${res.result}</div>`);
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
            });

            [...document.querySelectorAll('.calculator .digits, .calculator .operations .amber')]
                .map(btn => btn.addEventListener('click', (e) => input.value += e.target.innerHTML));
        </script>
    </body>
</html>