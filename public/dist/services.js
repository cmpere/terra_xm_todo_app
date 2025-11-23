class Http {
  constructor() {
    this.headers = {
      "Content-Type": "application/json",
      Accept: "application/json",
    };
  }

  async get(url) {
    const response = await $.ajax({
      url: url,
      type: "GET",
      headers: this.headers,
      contentType: "application/json; charset=utf-8",
      dataType: "json",
    });

    return response;
  }

  post(url, data, onSuccess, onFail) {
    $.ajax({
      url: url,
      data: JSON.stringify(data),
      type: "POST",
      headers: this.headers,
      contentType: "application/json; charset=utf-8",
      dataType: "json",
    })
      .done(onSuccess)
      .fail(onFail);
  }

  patch(url, data, onSuccess, onFail) {
    $.ajax({
      url: url,
      data: data,
      type: "PATCH",
      headers: this.headers,
    })
      .done(onSuccess)
      .fail(onFail);
  }

  destroy(url, onSuccess, onFail) {
    $.ajax({
      url: url,
      type: "DELETE",
      headers: this.headers,
    })
      .done(onSuccess)
      .fail(onFail);
  }
}

class Todo {
  constructor(client) {
    this.client = client;
  }

  async get() {
    return await this.client.get(`/api.php`);
  }

  add(data, onSuccess, onFail) {
    this.client.post(`/api.php`, data, onSuccess, onFail);
  }

  update(id, data, onSuccess, onFail) {
    const params = new URLSearchParams({ id }).toString();
    this.client.patch(`/api.php?${params}`, data, onSuccess, onFail);
  }

  destroy(id, onSuccess, onFail) {
    const params = new URLSearchParams({ id }).toString();
    this.client.destroy(`/api.php?${params}`, onSuccess, onFail);
  }
}
