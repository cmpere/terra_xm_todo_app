let state = {
  common: {
    modal: {
      settings: {
        autoOpen: false,
        resizable: false,
        height: "auto",
        width: 400,
        modal: true,
      },
    },
  },
  info: { data: {} },
  list: { data: [] },
};

$(async function () {
  const list = async () => {
    const { data } = await new Todo(new Http()).get();
    state.list.data = data;
    $("#todo-list").html(data.map((todo) => renderTodo(todo)).join(""));
    lucide.createIcons();
  };

  const handleAdd = (e) => {
    e.preventDefault();
    new Todo(new Http()).add(
      { task_name: $("#task_name").val() },
      async function () {
        $("div.success")
          .text("Tarea creada")
          .show()
          .delay(1500)
          .fadeOut("slow");

        $("#task_name").val(null);
        await list();
      },
      function () {
        $("div.error")
          .text("Ocurrio un error")
          .show()
          .delay(4000)
          .fadeOut("slow");
      }
    );
  };

  const handleDestroy = (e) => {
    e.preventDefault();
    const found = state.list.data.find(
      (todo) => todo.id === $(e.currentTarget).data("id")
    );
    state.info.data = { ...(found ?? {}) };
    $("#destroy-confirm-message").text(state.info.data.task_name);
    $("#destroy-confirm").dialog("open");
  };

  const handleOnEnterAdd = (e) => {
    if (e.key === "Enter") {
      handleAdd(e);
    }
  };

  const handleDeleteConfirmation = function () {
    new Todo(new Http()).destroy(
      state.info.data?.id,
      async function () {
        $("div.success")
          .text("Tarea eliminada")
          .show()
          .delay(1500)
          .fadeOut("slow");

        $("#destroy-confirm").dialog("close");

        await list();
      },
      function () {
        $("div.error")
          .text("Ocurrio un error")
          .show()
          .delay(4000)
          .fadeOut("slow");
      }
    );
  };

  const handleDeleteCancelation = function () {
    $("#destroy-confirm").dialog("close");
  };

  await list();

  $(document).on("click", ".btn.add", handleAdd);
  $(document).on("click", ".btn.destroy", handleDestroy);
  $(document).on("keydown", "#task_name", handleOnEnterAdd);

  $("#destroy-confirm").dialog({
    ...state.common.modal.settings,
    buttons: {
      Eliminar: handleDeleteConfirmation,
      Cancelar: handleDeleteCancelation,
    },
  });
});
