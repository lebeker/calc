'use strict';

export class CalcAPI {
    _request = (equation, variables  = []) =>
        fetch('/calc', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({equation, variables})
        })
}
