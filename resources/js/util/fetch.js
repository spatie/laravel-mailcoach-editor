import { $ } from "./query";

export async function jsonFetch(route, data) {
    const response = await fetch(route, {
        method: 'POST',
        body: data,
        credentials: 'same-origin',
        headers: {
            'X-CSRF-Token': $('[name="_token"]').value,
        },
    })

    return response.json();
}

export async function fetchHtml(route, data) {
    const response = await fetch(route, {
        method: 'POST',
        body: JSON.stringify({ data: data }),
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': $('[name="_token"]').value,
        },
    })

    const json = await response.json();

    return json.html;
}
