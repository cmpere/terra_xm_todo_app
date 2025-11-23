let state = { upsert: { data: {} } };

$(async function () {
  const handleOnEnterSave = (e) => {
    if (e.key === "Enter") {
      handleSave(e);
    }
  };

  const handleSave = (e) => {
    e.preventDefault();
    new Todo(new Http()).update(
      state.upsert.data?.id,
      { task_name: $("#task_name").val() },
      function () {
        $("div.success")
          .text("Cambios guardados")
          .show()
          .delay(1500)
          .fadeOut("slow");

        setTimeout(() => {
          window.location.href = "/index.php";
        }, 800);
      },
      function () {
        $("div.error")
          .text("Success delete")
          .show()
          .delay(4000)
          .fadeOut("slow");
      }
    );
  };

  $(document).on("click", ".btn.save", handleSave);
  $(document).on("keydown", "#task_name", handleOnEnterSave);
});
