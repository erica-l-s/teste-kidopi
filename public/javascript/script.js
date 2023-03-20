const selectCountry = country.addEventListener("change", async function () {

    //pegando valor do select para passar na URL

    let country = document.getElementById("country").value
    let url = `/api/save/${country}`
    let lastResult = '/api/last-access'


    //aplicando API para chamar como objeto

    let result = await fetch(url)
    let data = await result.json()

    let access = await fetch(lastResult)
    let dataAccess = await access.json()


    // transformando objeto de array em array de array para conseguir interar a aplicação

    let covid = Object.keys(data).map(function () {})

    //chamando a aplicação na tela e criando tabela

    function load() {

        const lastCountry = document.getElementById('lastCountry')
        const lastData = document.getElementById('lastData')

        lastCountry.innerHTML = dataAccess.country
        lastData.innerHTML = dataAccess.date

        // Criando a tabela no HTML
        const table = document.getElementById('table');
        table.innerText = ''

        // Criando a Primeira linha para identificação de cada item

        const colum = document.createElement('thead')

        const headStates = document.createElement('th')
        const headConfirmed = document.createElement('th')
        const headDeaths = document.createElement('th')

        headStates.innerHTML = "Provincias"
        headConfirmed.innerHTML = "Confirmados"
        headDeaths.innerHTML = "Mortos"

        colum.appendChild(headStates)
        colum.appendChild(headConfirmed)
        colum.appendChild(headDeaths)

        table.appendChild(colum)

    
        // Criando a linha para item do array
        for (let i = 0; i < covid.length; i++) {
            const row = document.createElement('tr');


            // Criando as celulas para cada item do array
            const states = document.createElement('td');
            const confirmed = document.createElement('td');
            const deaths = document.createElement('td');

            // Populando as celulas de cada array
            states.innerText = data[i].ProvinciaEstado;
            confirmed.innerText = data[i].Confirmados;
            deaths.innerText = data[i].Mortos;

            // Acrescentando as celulas de cada linha 
            row.appendChild(states);
            row.appendChild(confirmed);
            row.appendChild(deaths);

            // Acrescentando a linha da tabela
            table.appendChild(row);
        }

        // Acrescentando a tabela para o elemento da pagina
        const container = document.getElementById('table');
        container.appendChild(table);



    }
    return load()



})