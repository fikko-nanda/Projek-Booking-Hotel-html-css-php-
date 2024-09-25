document.getElementById('roomForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const category = document.getElementById('category').value;
    const price = document.getElementById('price').value;
    const imageFile = document.getElementById('image').files[0];
    
    if (category && price && imageFile) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imageUrl = e.target.result;
            addRow(category, price, imageUrl);
        }
        reader.readAsDataURL(imageFile);
    }
});

function addRow(category, price, imageUrl) {
    const tableBody = document.getElementById('roomTableBody');
    const rowCount = tableBody.rows.length + 1;
    
    const row = document.createElement('tr');
    
    const cell1 = document.createElement('td');
    cell1.innerText = rowCount;
    
    const cell2 = document.createElement('td');
    const img = document.createElement('img');
    img.src = imageUrl;
    cell2.appendChild(img);
    
    const cell3 = document.createElement('td');
    cell3.innerHTML = `Name : ${category}<br>Price : $${price}.00`;
    
    const cell4 = document.createElement('td');
    const editBtn = document.createElement('button');
    editBtn.innerText = 'Edit';
    editBtn.classList.add('edit-btn');
    const deleteBtn = document.createElement('button');
    deleteBtn.innerText = 'Delete';
    deleteBtn.classList.add('delete-btn');
    deleteBtn.addEventListener('click', function() {
        tableBody.removeChild(row);
    });
    
    cell4.appendChild(editBtn);
    cell4.appendChild(deleteBtn);
    
    row.appendChild(cell1);
    row.appendChild(cell2);
    row.appendChild(cell3);
    row.appendChild(cell4);
    
    tableBody.appendChild(row);
}
