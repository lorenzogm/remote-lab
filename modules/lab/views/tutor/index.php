{{ streams:single stream="subjects" where="`created_by`='{current_user:id}'" }}
<div>
    <h2>{{ subject_name }}</h2>
    <a href="{{ program:file }}">Descargar programa</a>
    <a href="{{ url:site uri='lab/practice/create_practice' }}">Crear práctica</a>
</div>

    {{ streams:cycle stream="practices" where="`subject`={id} }}

    <ul>
        {{ entries }}

            <li>
                <a href="{{ url:site uri='lab/practice' }}/{{ id }}">{{ practice_title }}</a>
                hasta el <?php echo date('d/m/Y',time((float)"{{expiration_date}}"))?>
                <a href="{{ program:file }}">Descargar</a>
            </li>

        {{ /entries }}
    </ul>

    {{ /streams:cycle }}

{{ /streams:single }}