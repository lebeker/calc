<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <link rel="stylesheet" href="/css/style.css">
        <script src="/js/main.js" type="module"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h1>Calc +</h1>
            </div>
            <div class="row">
                <div class="col s3">
                    <>
                    <ul class="collection">
                        <li class="collection-item">varOne</li>
                        <li class="collection-item">varTwo</li>
                        <li class="collection-item">Const</li>
                        <li class="collection-item">cOnSt</li>
                    </ul>
                </div>
                <div class="col s6">
                    <div class="calculator card">
                        <div class="input"><input id="calc-input" /></div>
                        <div class="digits">
                            <div class="btn grey lighten-1">7</div><div class="btn grey lighten-1">8</div><div class="btn grey lighten-1">9</div>
                            <div class="btn grey lighten-1">4</div><div class="btn grey lighten-1">5</div><div class="btn grey lighten-1">6</div>
                            <div class="btn grey lighten-1">1</div><div class="btn grey lighten-1">2</div><div class="btn grey lighten-1">3</div>
                            <div class="btn grey lighten-1">0</div><div class="btn grey">.</div><div class="btn blue">M</div>
                        </div>
                        <div class="operations">
                            <div class="btn red lighten-3 backspace"><-</div><div class="btn red darken-4 clear"><b>C</b></div>
                            <div class="btn amber">(</div><div class="btn amber">)</div>
                            <div class="btn amber">+</div><div class="btn amber">-</div>
                            <div class="btn amber">*</div><div class="btn amber">/</div>
                        </div>
                        <button id="calcBtn" class="btn orange eq"> = </button>
                    </div>
                </div>
                <div class="col s3">3</div>
            </div>
        </div>
        <script type="module">
            import {CalcAPI} from '/js/main.js';
            const api = new CalcAPI();
            const input = document.getElementById('calc-input');

            document.getElementById('calcBtn').addEventListener('click', (e) =>
                api._request(input.value)
            );
console.log(document.querySelectorAll('.calculator .digits, .calculator .operations .amber'));
            [...document.querySelectorAll('.calculator .digits, .calculator .operations .amber')]
                .map(btn => {
                    console.log(btn);
                    btn.addEventListener('click', (e) => {
                        console.log('click: ' + e.target.innerHTML);
                        input.value += e.target.innerHTML;
                    })
                });
        </script>
    </body>
</html>