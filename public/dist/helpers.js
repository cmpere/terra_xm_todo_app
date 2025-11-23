function renderTodo(todo) {
  return (
    '<div class="py-6 px-4 flex items-center justify-between hover:bg-slate-50">' +
    `   <p>${todo?.task_name}</p>` +
    '   <div class="flex gap-4 items-center justify-between">' +
    `      <button class="btn cursor-pointer hover:text-terra text-slate-900/50 edit data-id="${todo?.id}">` +
    '           <i data-lucide="pencil"></i>' +
    "       </button>" +
    `      <button class="btn cursor-pointer hover:text-rose-600  text-slate-900/50 destroy" data-id="${todo?.id}">` +
    '           <i data-lucide="trash"></i>' +
    "       </button>" +
    "   </div>" +
    "</div>"
  );
}
