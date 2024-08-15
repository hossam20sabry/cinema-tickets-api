const seat = document.querySelectorAll('.seat');
const submitButton = document.querySelector('#btn');
const form = document.querySelector('#seats-form');

seat.forEach(seat => {
    seat.addEventListener('click', () => {
        if (!seat.classList.contains('occupied')) {
            if (seat.classList.contains('active')) {
                seat.classList.remove('active');
                seat.style.backgroundColor = '#444451';
                removeHiddenInput(seat.getAttribute('data-seat-id'));
            } else {
                seat.classList.add('active');
                seat.style.backgroundColor = '#0081cb';
                createHiddenInput(seat.getAttribute('data-seat-id'));
            }
        }
    });
});

function createHiddenInput(seatId) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'seatsIds[]';
    input.value = seatId;
    form.appendChild(input);
    console.log(seatId)
}

function removeHiddenInput(seatId) {
    const inputs = form.querySelectorAll('input[name="seatsIds[]"]');
    inputs.forEach(input => {
        if (input.value === seatId) {
            form.removeChild(input);
        }
    });
}

// Submit the form when the button is clicked
submitButton.addEventListener('click', () => {
    form.submit();
});

// fake 
const fakeSeat = document.querySelectorAll('.fake_seat');
fakeSeat.forEach(fake => {
    fake.addEventListener('click', (event) => {
        event.preventDefault();
    });
})
