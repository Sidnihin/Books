async function searchAuthors() {
    let title = document.getElementById("bookTitle").value;
    if (!title.trim()) return alert("Введите название книги");

    let response = await fetch(`search.php?book_title=${encodeURIComponent(title)}`);
    let data = await response.json();

    if (data.error) {
        document.getElementById("results").innerHTML = `<h3 style="color:red;">${data.error}</h3>`;
    } else {
        let authors = data.authors.map(a => `<li>${a.name}</li>`).join("");
        document.getElementById("results").innerHTML = `<h3>Авторы:</h3><ul>${authors}</ul>`;
    }
}

async function searchBooks() {
    let name = document.getElementById("authorName").value;
    if (!name.trim()) return alert("Введите имя автора");

    let response = await fetch(`search.php?author_name=${encodeURIComponent(name)}`);
    let data = await response.json();

    if (data.error) {
        document.getElementById("results").innerHTML = `<h3 style="color:red;">${data.error}</h3>`;
    } else {
        let books = data.books.map(b => `<li>${b.title}</li>`).join("");
        document.getElementById("results").innerHTML = `<h3>Книги:</h3><ul>${books}</ul>`;
    }
}