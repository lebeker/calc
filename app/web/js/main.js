'use strict';

export class CalcAPI {
    _request = (equation) =>
        fetch('/calc', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({equation})
        })
}
