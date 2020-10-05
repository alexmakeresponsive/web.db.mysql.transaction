SELECT authors.id, authors.name_last, authors_books.id_author, authors_books.id_book, books.title
    FROM authors
    LEFT JOIN authors_books ON authors.id = authors_books.id_author
    LEFT JOIN books ON authors_books.id_book = books.id
WHERE books.title IS NOT NULL;
