{{ streams:single stream="practices" where="`id`='<?php echo $id;?>'" }}
<div>
    <h2>{{ subject_name }}</h2>
    <a href="{{ program:file }}">Descargar programa</a>
    <a href="{{ url:site }}lab/practice/create_practice">Crear práctica</a>
</div>
    {{ vardump:callback }}asdf
    {{ streams:cycle stream="students" where="`subject`={subject:id} }}

    <ul>
        {{ entries }}

            <li>
                <a href="lab/practice/{{ id }}">{{ practice_title }}</a>
                hasta el <?php echo date('d/m/Y',time((float)"{{expiration_date}}"))?>
                <a href="{{ program:file }}">Descargar</a>
            </li>

        {{ /entries }}
    </ul>

    {{ /streams:cycle }}

{{ /streams:single }}