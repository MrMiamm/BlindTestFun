var table = document.getElementById('table-style-artist');
table.style.display = 'none';

document.getElementById('submitStyleBtn').addEventListener('click', function(event) {
    event.preventDefault();

    let style = document.getElementById('style').value;
    let artiste = document.getElementById('artiste').value;
    let switchValue = document.getElementById('switch').checked;

    console.log(style, artiste, switchValue);

    if (((style === '') && (switchValue === false)) || ((artiste === '') && (switchValue === true))) {
        alert('Veuillez remplir tous les champs');
    } else{
        let tr = document.createElement('tr');
        let td1 = document.createElement('td');
        let td2 = document.createElement('td');
        if (switchValue) {
            td1.innerText = "Artiste";
            td2.innerText = artiste;
        } else{
            td1.innerText = "Style";
            td2.innerText = style;
        }
        tr.appendChild(td1);
        tr.appendChild(td2);

        //Check si la ligne existe déjà
        let exist = false;
        for (let i = 0; i < table.rows.length; i++) {
            if ((table.rows[i].cells[0].innerText === td1.innerText) && (table.rows[i].cells[1].innerText === td2.innerText)) {
                exist = true;
            }
        }
        if (exist) {
            alert('Cette ligne existe déjà');
        } else{
            table.appendChild(tr);
            table.style.display = 'block';
        }
    }
});