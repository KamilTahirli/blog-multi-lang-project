const getErrors = function (error) {
    const errorsData = Object.entries(error.response.data.errors)
    const errors = []

    errorsData.forEach(error =>
    {
      error[1].forEach(err  =>  {
        errors.push(err)
        alertify.error(err)
      })
    })
    return errors
}