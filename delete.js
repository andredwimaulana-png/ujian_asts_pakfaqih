function deleteData() {
    fetch("https://jsonplaceholder.typicode.com/users/1", {
        method: "DELETE"
    })
        .then(response => {
            if (response.ok) {
                console.log("Data berhasil dihapus");
            } else {
                console.log("Gagal menghapus data");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
}