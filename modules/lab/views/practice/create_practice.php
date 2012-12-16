<h1>Crear práctica</h1>
{{ streams:form stream="practices" mode="new" required="<span class='required'>*</span>" return="lab/tutor" }}

{{ form_open }}

<table>

    {{ fields }}


    {{ if input_slug == "subject" }}

    <tr class="{{ odd_even }}">
        <td width="250">{{ input_title }}{{ required }} <small>{{ instructions }}</small></td>
        <td>
            <select name="subject" id="subject">
                <?php foreach($subjects['entries'] as $subject):?>
                    <option value="<?php echo $subject['id']?>"><?php echo $subject['subject_name'];?></option>
                <?php endforeach;?>
            </select>
            {{ error }}
        </td>
    </tr>

    {{ else }}

    <tr class="{{ odd_even }}">
        <td width="250">{{ input_title }}{{ required }} <small>{{ instructions }}</small></td>
        <td>{{ input }}{{ error }}</td>
    </tr>

    {{ endif }}

    {{ /fields }}

</table>

<button class="btn btn-large btn-danger"><i class="icon-white icon-ok"></i>Crear práctica</button>

{{ form_close }}

{{ /streams:form }}
