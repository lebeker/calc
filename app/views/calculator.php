<html>
    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <script src="/js/main.js" type="module"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <h1>Calc +</h1>
            </div>
            <div class="row">
                <div class="col s1">1</div>
                <div class="col s4">
                    <div class="container card">
                        <div class="row">
                            <div class="col s1 btn">7</div><div class="col s1 btn">8</div><div class="col s1 btn">9</div>
                        </div>
                        <div class="row">
                            <div class="col s1 btn">4</div><div class="col s1 btn">5</div><div class="col s1 btn">6</div>
                        </div>
                        <div class="row">
                            <div class="col s1 btn">1</div><div class="col s1 btn">2</div><div class="col s1 btn">3</div>
                        </div>
                        <button id="calcBtn" class="btn orange btn-large"> = </button>
                    </div>
                </div>
                <div class="col s3">3</div>
            </div>
        </div>
        <script type="module">
            import {CalcAPI} from '/js/main.js';
            const api = new CalcAPI();

            document.getElementById('calcBtn').addEventListener('click', (e) =>
                api._request('(34-44)*19 - 6')
            )
        </script>
    </body>
</html>