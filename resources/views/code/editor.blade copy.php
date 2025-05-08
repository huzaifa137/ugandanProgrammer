@extends('layouts.master')

@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
@endsection

@section('page-header')
    <div class="page-header">
        <div class="page-leftheader">
            <h4 class="page-title">Code Editor</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#" class="d-flex"><i class="fa fa-home"></i><span
                            class="breadcrumb-icon"> Home</span></a></li>
                <li class="breadcrumb-item active" aria-current="page">Code Editor</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Interactive Code Editor</h3>
                    <select id="language-select" class="form-control w-25" onchange="changeLanguage(this.value)">
                        <option value="javascript">JavaScript</option>
                        <option value="html">HTML</option>
                        <option value="css">CSS</option>
                        <option value="python">Python</option>
                        <option value="php">PHP</option>
                    </select>
                </div>
                <div class="card-body">
                    <div id="editor" style="height: 400px; border: 1px solid #ccc;"></div>
                    <button class="btn btn-primary mt-3" onclick="runCode()"><i class="fas fa-play"></i> Run Code</button>

                    <div class="mt-3">
                        <h5>Output:</h5>
                        <iframe id="preview-frame"
                            style="width:100%; height:200px; border:1px solid #ccc; display:none;"></iframe>
                        <pre id="output" style="background: #f5f5f5; padding: 10px; min-height: 100px; display:none;"></pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- Monaco Editor -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.45.0/min/vs/loader.min.js"></script>

    <!-- Pyodide (Python WASM) -->
    <script src="https://cdn.jsdelivr.net/pyodide/v0.23.4/full/pyodide.js"></script>

    <!-- PHP WASM -->
    <script src="https://cdn.jsdelivr.net/npm/php-wasm/wasm_exec.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/php-wasm/php.js"></script>

    <script>
        let editor;
        let currentLang = 'javascript';

        let pyodideReady = false;
        let pyodide = null;

        let phpReady = false;
        let phpRunner = null;

        const starterCode = {
            javascript: `function greet(name) {
    return "Hello, " + name + "!";
}
console.log(greet("Huzaifa"));`,
            html: `<!DOCTYPE html>
<html>
<head><title>My Page</title></head>
<body>
    <h1>Hello, world!</h1>
</body>
</html>`,
            css: `body {
    background-color: lightblue;
    font-family: Arial;
}`,
            python: `print("Hello from Python!")`,
            php: `<?php
            echo 'Hello from PHP!';
            ?>`
        };

        // Load Monaco Editor
        require.config({
            paths: {
                'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.45.0/min/vs'
            }
        });

        require(['vs/editor/editor.main'], function() {
            editor = monaco.editor.create(document.getElementById('editor'), {
                value: starterCode[currentLang],
                language: currentLang,
                theme: 'vs-dark'
            });
        });

        // Wait until page is fully loaded
        window.addEventListener('load', async () => {
            // Load Pyodide
            try {
                pyodide = await loadPyodide();
                pyodideReady = true;
                console.log("✅ Pyodide loaded");
            } catch (err) {
                console.error("❌ Failed to load Pyodide:", err);
            }

            // Load PHP-WASM
            try {
                phpRunner = await createPHP();
                phpReady = true;
                console.log("✅ PHP-WASM loaded");
            } catch (err) {
                console.error("❌ Failed to load PHP-WASM:", err);
            }
        });

        function changeLanguage(lang) {
            currentLang = lang;
            monaco.editor.setModelLanguage(editor.getModel(), (lang === 'php' || lang === 'html') ? 'html' : lang);
            editor.setValue(starterCode[lang] || '');
            document.getElementById('output').style.display = 'none';
            document.getElementById('preview-frame').style.display = (lang === 'html' || lang === 'css') ? 'block' : 'none';
        }

        async function runCode() {
            const code = editor.getValue();
            const outputEl = document.getElementById('output');
            const iframe = document.getElementById('preview-frame');

            outputEl.style.display = 'block';
            outputEl.textContent = '';
            iframe.style.display = 'none';

            if (currentLang === 'javascript') {
                try {
                    const logs = [];
                    const originalLog = console.log;
                    console.log = function(...args) {
                        logs.push(args.join(' '));
                    };
                    const result = eval(code);
                    console.log = originalLog;
                    outputEl.textContent = logs.length ? logs.join('\n') : (result ?? '✅ Code executed.');
                } catch (e) {
                    outputEl.textContent = '❌ Error: ' + e.message;
                }
            } else if (currentLang === 'html') {
                iframe.srcdoc = code;
                outputEl.style.display = 'none';
                iframe.style.display = 'block';
            } else if (currentLang === 'css') {
                iframe.srcdoc = `<html><head><style>${code}</style></head><body><h1>Styled Output</h1></body></html>`;
                outputEl.style.display = 'none';
                iframe.style.display = 'block';
            } else if (currentLang === 'python') {
                if (!pyodideReady) {
                    outputEl.textContent = "⚠️ Pyodide is still loading...";
                    return;
                }
                try {
                    const result = await pyodide.runPythonAsync(code);
                    outputEl.textContent = result ?? "✅ Executed.";
                } catch (e) {
                    outputEl.textContent = '❌ Python Error: ' + e.message;
                }
            } else if (currentLang === 'php') {
                if (!phpReady || !phpRunner) {
                    outputEl.textContent = "⚠️ PHP engine still loading...";
                    return;
                }
                try {
                    const result = await phpRunner.run(code);
                    outputEl.textContent = result;
                } catch (e) {
                    outputEl.textContent = '❌ PHP Error: ' + e.message;
                }
            }
        }
    </script>
@endsection
