<h1>Crear asignatura</h1>
{{ streams:form stream="subjects" mode="new" required="<span class='required'>*</span>" return="lab/tutor" exclude="tutor" }}

{{ form_open }}

<table>

    {{ fields }}

    <tr class="{{ odd_even }}">
        <td width="250">{{ input_title }}{{ required }} <small>{{ instructions }}</small></td>
        <td>{{ input }}{{ error }}</td>
    </tr>

    {{ /fields }}

    <input type="hidden" name="tutor" value="{{ current_user:id }}" />

</table>

<button class="btn btn-large btn-danger"><i class="icon-white icon-ok"></i>Crear asignatura</button>

{{ form_close }}

{{ /streams:form }}
