/* === Submit Form Event === */
document.addEventListener("submit", async function(event) {
    // Check if the submitted element has the common class
    if (event.target.classList.contains("common-form")) {
        event.preventDefault();

        // Get references of error and success message elemetns
        let error_msg = document.getElementById("error_msg");
        let success_msg = document.getElementById("success_msg");
        let error_list = document.getElementById("error_list");

        // Keep the alert hidden for default
        error_msg.style.display = "none";
        success_msg.style.display = "none";
        error_list.style.display = "none";

        const form = event.target;
        const formData = new FormData(form);

        // View the form fields data
        /*for (let pair of formData.entries()) {
            console.log(pair[0] + ":" + pair[1]);
        }*/

        // Take out the API URL from form's action attritube
        let apiUrl = form.action;
        if (!apiUrl) {
            error_msg.style.display = "block";
            error_msg.innerHTML = "Route not defined";
            return;
        }

        // API Call
        try {
            const response = await fetch(apiUrl, {
                method: "POST",
                body: formData //JSON.stringify(Object.fromEntries(formData)),
            });

            const result = await response.json();
            console.log("RESULT", result);

            // check the status of the result
            if (result.status == true) {
                success_msg.style.display = "block";
                success_msg.innerHTML = result.message;

                // Redirect to other page
                if (result.redirect_to) {
                    window.location.href = result.redirect_to;
                }

                // Reset the form, after getting success response
                form.reset();
            } else if (result.errors) {
                let errors = result.errors;
                let errorUl = document.querySelector("#error_list ul");
                errorUl.innerHTML = "";

                for (let error in errors) {
                    let li = document.createElement("li");
                    li.textContent = errors[error];
                    errorUl.appendChild(li);
                }
                error_list.style.display = "block";
            } else {
                error_msg.style.display = "block";
                error_msg.innerHTML = result.message;
            }
        } catch (error) {
            error_msg.style.display = "block";
            error_msg.innerHTML = "Internal server error";
        }
    }
});
