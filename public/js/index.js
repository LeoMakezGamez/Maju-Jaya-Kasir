document.querySelectorAll('.btn').forEach(button => {
    button.addEventListener('click', () => {
        const icon = button.querySelector('i');
        if (icon) {
            icon.style.transform = 'rotate(360deg)';
            setTimeout(() => {
                icon.style.transform = '';
            }, 300); 
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const filterInput = document.getElementById('filter');
    const tableRows = document.querySelectorAll('.unit-table tbody tr');
    const tableBody = document.querySelector('.unit-table tbody');


    const noResultRow = document.createElement('tr');
    noResultRow.innerHTML = `<td colspan="5" style="text-align: center;">Item tidak ditemukan.</td>`;
    noResultRow.style.display = 'none';
    tableBody.appendChild(noResultRow);

    filterInput.addEventListener('input', function () {
        const query = this.value.toLowerCase();
        let hasMatch = false;

        tableRows.forEach(row => {
            const rowData = row.textContent.toLowerCase();
            if (rowData.includes(query)) {
                row.style.display = ''; 
                hasMatch = true; 
            } else {
                row.style.display = 'none'; 
            }
        });

        // Tampilkan pesan jika tidak ada hasil
        noResultRow.style.display = hasMatch ? 'none' : '';
    });
});
