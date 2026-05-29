async function submitPost() {
    const body = document.getElementById("post-body-inp").value;
    const response = await fetch("/feed", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')
                .content,
            "Content-Type": "application/json",
        },
        body: JSON.stringify({ body: body, type: "announcement" }),
    });
    // Handle response and call renderPosts()
}
