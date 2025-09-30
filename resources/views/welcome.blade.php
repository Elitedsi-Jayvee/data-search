<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Search</title>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <style>
        body{
            padding:30px;
        }
        .container{
            gap:10px;
            display:flex;
            flex-direction:column;
        }
        .output{
            border:1px solid black;
            width:100%;
            height:80vh;
            overflow-y: auto;
        }
        input[type=text]{
            padding:10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <input type="text" name="" id="searchInput" placeholder="Type to search...">
        <div class="output" id="output"></div>
    </div>

    <script>
        async function getCatFacts(search){
            try {
                const baseUri = "{{  url('search/') }}";
                const { data } = await axios.post( baseUri,{
                    query:search
                });
                const output = document.getElementById('output');
                const result = await data.suggestions;
                let cars = "";
                cars = "<ul>";
                Object.keys(result).forEach(index => {
                    cars += `<li>${result[index]}</li>`;
                });
                cars += "</ul>";
                output.innerHTML = cars; 
              
            } catch (error) {
                console.error('Error fetching data:', error);
                const output = document.getElementById('output');
                output.innerHTML = '<p>Error loading cat fact</p>';
            }
        }
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            const query = e.target.value;
            const output = document.getElementById('output');
            output.innerText = "Loading...";
            setTimeout(() => {
                    getCatFacts(e.target.value);
            }, 2000);
        });
    </script>
</body>
</html>