<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />
        <link rel="stylesheet" href="/css/style.css" />
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
                            <div id="backspace" class="btn red lighten-3"><-</div><div id="clear" class="btn red darken-4"><b>C</b></div>
                            <div class="btn amber">(</div><div class="btn amber">)</div>
                            <div class="btn amber">+</div><div class="btn amber">-</div>
                            <div class="btn amber">*</div><div class="btn amber">/</div>
                        </div>
                        <button id="calcBtn" class="btn orange eq"> = </button>
                    </div>
                    <div id="error" class="card red lighten-3" style="display: none"></div>
                    <p>You may use dconstants:
                        <ul>
                            <li><b>P</b> = &#x03c0; (<small><?=M_PI?></small>)</li>
                            <li><b>E</b> = e (<small><?=M_E?></small>)</li>
                        </ul>
                    </p>
                </div>
                <div id="result" class="col s3"></div>
            </div>
        </div>
        <script src="/js/main.js" type="module"></script>
    </body>
</html>
