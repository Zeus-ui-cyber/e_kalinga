function submitPost() {
    const title = document.getElementById("post-title-inp").value;
    const body = document.getElementById("post-body-inp").value;

    fetch("/feed", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
        },
        body: JSON.stringify({
            title,
            body,
            type: "announcement",
        }),
    })
        .then((res) => res.json())
        .then(() => location.reload());
}
