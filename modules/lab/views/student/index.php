<div>
    <a href="{{ url:site uri='lab/student/subject_register' }}">Ver asignaturas</a>
</div>

{{ streams:students where="`created_by`='[user_id]'" }}

    <ul>
    {{ entries }}

        {{ subject:subject_name }}
        {{ streams:practices include={subject:id} include_by="subject" order_by="expiration_date" sort="ASC" rename:id="practice_id" }}

                <li>
                    {{ practice_title }}
                    hasta el {{ helper:date format="d/m/Y" timestamp=expiration_date }}
                    <a href="{{ program:file }}">Descargar</a>
                    {{ streams:bookings include=practice_id include_by="practice" }}
                    {{ helper:date timestamp=booking_date }}
                    {{ /streams:bookings }}
                </li>

        {{ /streams:practices }}

    {{ /entries }}

    </ul>
{{ /streams:students }}